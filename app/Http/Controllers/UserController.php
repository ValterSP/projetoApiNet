<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use Illuminate\View\View;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['updatePhoto','removePhoto']);
        $this->middleware('auth');
    }

    public function create(): View
    {
        $user = new User();
        return view('user.create')->withUser($user);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $formData = $request->validated();

        $user = DB::transaction(function () use ($formData) {
            $newUser = new User();
            $newUser->name = $formData['name'];
            $newUser->email = $formData['email'];
            $newUser->user_type = $formData['user_type'];
            $newUser->password = Hash::make($formData['password']);
            $newUser->save();
            return $newUser;
        });

        $url = route('user.index');
        $htmlMessage = "User <a href='$url'>#{$user->id}</a>
                        <strong>\"{$user->name}\"</strong> foi criada com sucesso!";
        return redirect()->route('user.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function show(User $user): View
    {
        $this->authorize('view', $user);
        return view('user.show')->with('user',$user);
    }


    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        return view('user.edit')->with('user',$user);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);
        $user->update($request->validated());
        $url = route('user.show',['user' => $user]);
        $htmlMessage = "User <a href='$url'>#{$user->id}</a>
                        <strong>\"{$user->name}\"</strong> foi alterado com sucesso!";
        return redirect()->route('user.show', ['user' => $user])
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function restore(int $id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);
        if($user->user_type == 'C')
        {
            $customer = Customer::withTrashed()->findOrFail($id);
            $customer->restore();

        }
        $user->restore();
        $user->save();
        $customer->save();

        return redirect()->back()
            ->with('alert-msg', 'Usuário restaurado com sucesso.')
            ->with('alert-type', 'success');
    }


    public function destroy(User $user): RedirectResponse
    {
        if ($user->user_type == 'C') {
            $user->delete();
            $user->customer->delete();
        } else {
            $user->forceDelete();
        }
        return redirect()->back()->with('success', 'Usuário excluído com sucesso.');
    }

    public function index(Request $request): View
    {

        $filterByType = $request->user_type ?? '';
        $filterByNome = $request->name ?? '';
        $filterByBlocked = $request->blocked ?? '';
        $usersQuery = User::query();
        if($filterByBlocked !== '')
        {
            $usersQuery->where('blocked',$filterByBlocked);
        }
        if ($filterByType !== ''){
            $usersQuery->where('user_type', $filterByType);
        }
        if ($filterByNome !== '') {
            $usersQuery->where('name', 'like', "%$filterByNome%");
        }

        $users = $usersQuery->withTrashed()->paginate(20);

        return view('user.index', compact('users','filterByType', 'filterByNome', 'filterByBlocked'));

    }

    public function updatePhoto(Request $request, User $user)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);
        // Delete the old photo if it exists
        if ($user->photo_url) {
            Storage::delete($user->photo_url);
        }
        // Store the new photo
        $photoPath = $request->file('photo')->store('','photos');

        // Update the user's photo_url attribute
        $user->update(['photo_url' => $photoPath]);

        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }

    public function removePhoto(Request $request, User $user)
    {
        if($user->user_type == 'C' && Auth::user() != $user)
        {
            return redirect()->route('home');
        }
        $user->photo_url = null;
        $user->save();

        if ($user->photo_url) {
             Storage::delete($user->photo_url);
        }

        return redirect()->back()->with('alert-msg', 'A foto foi removida com sucesso!')->with('alert-type', 'success');
    }

    public function changeBlock(User $user)
    {
        $user->blocked = !$user->blocked;
        $user->save();
        $message = $user->blocked ? 'O utilizador foi bloqueado com sucesso' : 'O utilizador foi desbloqueado com sucesso';
        $alertType = 'success';

        return redirect()->back()->with('alert-msg', $message)->with('alert-type', $alertType);
    }


}
