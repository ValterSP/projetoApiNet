<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('create');
        $this->middleware('customer');
    }

    public function show(Request $request): View
    {
        $user = Auth::user();
        $customer = $user->customer;

        return view('customer.show', compact('customer', 'user'));
    }

    public function create(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        // Create the customer
        $customer = Customer::create([
            'id' => $validatedData['user_id'],
        ]);
    }

    public function edit(Request $request): View
    {
        $user = Auth::user();
        $customer = $user->customer;
        return view('customer.edit', compact('customer', 'user'));
    }

    public function update(CustomerRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        $customer = Auth::user()->customer;
        $customer = DB::transaction(function () use ($formData, $customer) {
            $customer->nif = $formData['nif'] ?? null;
            $customer->address = $formData['address'] ?? null;
            $customer->default_payment_type = $formData['default_payment_type'] ?? null;
            $customer->default_payment_ref = $formData['default_payment_ref'] ?? null;
            $customer->save();
            return $customer;
        });
        $url = route('customer.show');
        $htmlMessage = "Perfil atualizado com sucesso";
        return redirect()->route('customer.show')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

}
