<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategorieRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function destroy(int $id): RedirectResponse
    {
        $categoria = Categorie::findOrFail($id);
        $categoria->delete();
        return redirect()->back()
            ->with('alert-msg', "Categoria deletada com sucesso")
            ->with('alert-type', 'success');
    }

    public function  create()
    {
        $categorie = Categorie::all();
        session(['previous_url' => url()->previous()]);
        return view('categorie.create', compact('categorie'));
    }

    public function index(Request $request)
    {
        $filterByNome = $request->name ?? '';

        $categoriaQuerry = Categorie::query();
        if ($filterByNome !== '') {
            $categoriaQuerry->where('name', 'like', "%$filterByNome%");
        }

        $categorias = $categoriaQuerry->orderBy('name','asc')->paginate(20);

        return view('categorie.index', compact('categorias', 'filterByNome'));
    }

    public function store(CategorieRequest $request): RedirectResponse
    {

        $formData = $request->validated();
        $previousUrl = session('previous_url');
        $newCategorie = DB::transaction(function () use ($formData) {
            $newCategorie = new Categorie();
            $newCategorie->name = $formData['name'];
            $newCategorie->save();
            return $newCategorie;
        });

        $htmlMessage = "Categoria <strong>\"{$newCategorie->name}\"</strong> foi criada com sucesso!";
        return redirect($previousUrl)
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }
}
