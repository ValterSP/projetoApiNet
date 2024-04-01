<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;
use App\Models\TshirtImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Categorie;
use App\Models\Color;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TshirtImageRequest;
use Illuminate\Http\RedirectResponse;

class TshirtImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only('store','destroy','update', 'restore');
        $this->middleware('auth')->only('indexOwn');
        $this->middleware('notEmployee')->only('edit', 'create');
        $this->middleware('customer')->only('indexOwn','storeOwn','getPrivateImage', 'updateOwn', 'destroyOwn');
    }

    public function index(Request $request)
    {
        $preco = Price::first();
        $cores = Color::orderBy('name')->get();
        $categorias = Categorie::has('tshirtImage')->orderBy('name')->get();
        $filterByCategorie = $request->category_id ?? '';
        $filterByNome = $request->name ?? '';

        $tshirtImagesQuery = TshirtImage::query();
        if ($filterByCategorie !== ''){
            $tshirtImagesQuery->where('category_id', $filterByCategorie);
        }
        if ($filterByNome !== '') {
            $tshirtImagesQuery->where('name', 'like', "%$filterByNome%");
        }
        if(Auth::check() && Auth::user()->user_type == 'A')
        {
            $tshirtImagesQuery->withTrashed();
        }
        $tshirtImages = $tshirtImagesQuery->orderBy('category_id')->whereNull('customer_id')->paginate(20);
        return view('tshirtImage.index', compact('categorias','filterByCategorie','tshirtImages','filterByNome','cores','preco'));
    }

    public function indexOwn(Request $request)
    {
        $preco = Price::first();
        $cores = Color::orderBy('name')->get();
        $filterByNome = $request->name ?? '';

        $tshirtImagesQuery = TshirtImage::query();
        $tshirtImagesQuery->where('customer_id', Auth::user()->id);
        if ($filterByNome !== '') {
            $tshirtImagesQuery->where('name', 'like', "%$filterByNome%");
        }

        $tshirtImages = $tshirtImagesQuery->orderBy('category_id')->paginate(20);
        return view('tshirtImage.indexOwn', compact('tshirtImages','filterByNome','cores','preco'));
    }

    public function create()
    {
        $tshirtImage = new TshirtImage();
        $categorias = Categorie::orderBy('name')->get();
        return view('tshirtImage.create', compact('tshirtImage','categorias'));
    }

    public function store(TshirtImageRequest $request): RedirectResponse
    {

        $formData = $request->validated();
        $imagePath = $request->file('image')->store('','tshirt_images');

        $newtshirtImage = DB::transaction(function () use ($formData, $imagePath) {
            $newtshirtImage = new TshirtImage();
            $newtshirtImage->name = $formData['name'];
            $newtshirtImage->description = $formData['description'];
            $newtshirtImage->category_id = $formData['category_id'];
            $newtshirtImage->image_url = $imagePath;
            $newtshirtImage->save();
            return $newtshirtImage;
        });

        $htmlMessage = "Imagem <strong>\"{$newtshirtImage->name}\"</strong> foi criada com sucesso!";
        return redirect()->route('catalogo')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function storeOwn(TshirtImageRequest $request): RedirectResponse
    {

        $formData = $request->validated();
        $filePath = $request->file('image')->store('tshirt_images_private');
        $imageName = basename($filePath);

        $newtshirtImage = DB::transaction(function () use ($formData, $imageName) {
            $newtshirtImage = new TshirtImage();
            $newtshirtImage->name = $formData['name'];
            $newtshirtImage->description = $formData['description'];
            $newtshirtImage->category_id = $formData['category_id'];
            $newtshirtImage->customer_id = $formData['customer_id'];
            $newtshirtImage->image_url = $imageName;
            $newtshirtImage->save();
            return $newtshirtImage;
        });

        $htmlMessage = "Imagem <strong>\"{$newtshirtImage->name}\"</strong> foi criada com sucesso!";
        return redirect()->route('tshirtImage.indexOwn')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(int $id): RedirectResponse
    {
        $image = TshirtImage::withTrashed()->findOrFail($id);
        if ($image->trashed()) {
            $image->forceDelete();
            if ($image->image_url) {
                Storage::delete($image->image_url);
            }
            return redirect()->back()->with('alert-msg', 'Imagem excluída permanentemente com sucesso.')
                ->with('alert-type', 'success');
        }
        if ($image->orderItems != null) {
            return redirect()->back()->with('alert-msg', 'Não é possível excluir a imagem pois esta ja foi incluida numa encomenda.')
                ->with('alert-type', 'danger');
        }
        $image->delete();
        return redirect()->back()->with('alert-msg', 'Imagem excluída com sucesso.')
            ->with('alert-type', 'success');
    }

    public function edit(TshirtImage $tshirtImage): View
    {
        $categorias = Categorie::orderBy('name')->get();
        return view('tshirtImage.edit', compact('tshirtImage', 'categorias'));
    }

    public function update(TshirtImageRequest $request, TshirtImage $tshirtImage)
    {
        $formData = $request->validated();
        DB::transaction(function () use ($formData, $tshirtImage){
            $tshirtImage->name = $formData['name'];
            $tshirtImage->description = $formData['description'];
            $tshirtImage->category_id = $formData['category_id'];
            $tshirtImage->save();
        });

        return redirect()->route('catalogo')
            ->with('alert-msg', "Imagem atualizada com sucesso")
            ->with('alert-type', 'success');

    }


    public function restore(int $id): RedirectResponse
    {
        $tshirtImage = TshirtImage::withTrashed()->findOrFail($id);

        $tshirtImage->restore();
        $tshirtImage->save();

        return redirect()->back()
            ->with('alert-msg', 'Usuário restaurado com sucesso.')
            ->with('alert-type', 'success');
    }

    public function destroyOwn(int $id): RedirectResponse
    {

        $image = TshirtImage::findOrFail($id);
        if ($image->orderItem->count() != 0) {
            $image->delete();
            return redirect()->back()->with('alert-msg', 'Imagem excluída com sucesso.')
                ->with('alert-type', 'success');
        }

        $image->forceDelete();
        if ($image->image_url) {
            Storage::disk('tshirt_images_private')->delete($image->image_url);
        }
        return redirect()->back()->with('alert-msg', 'Imagem excluída com sucesso.')
            ->with('alert-type', 'success');

    }

    public function updateOwn(TshirtImageRequest $request, TshirtImage $tshirtImage)
    {
        $formData = $request->validated();
        DB::transaction(function () use ($formData, $tshirtImage){
            $tshirtImage->name = $formData['name'];
            $tshirtImage->description = $formData['description'];
            $tshirtImage->save();
        });

        return redirect()->route('tshirtImage.indexOwn')
            ->with('alert-msg', "Imagem atualizada com sucesso")
            ->with('alert-type', 'success');
    }
}
