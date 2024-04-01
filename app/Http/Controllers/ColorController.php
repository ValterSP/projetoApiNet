<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class ColorController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['updatePhoto', 'removePhoto']);
        $this->middleware('auth');
    }

    public function index()
    {
        $cores = Color::withTrashed()->orderBy('name')->paginate(20);
        return view('color.index', compact('cores'));
    }


    public function store(ColorRequest $request): RedirectResponse
    {

        $formData = $request->validated();
        $color = DB::transaction(function () use ($formData) {
            $newColor = new Color();
            $newColor->name = $formData['name'];
            $newColor->code = str_replace('#','',$formData['code']);
            $newColor->save();
            return $newColor;
        });

        $imagePath = public_path('img/plain_white.png');

        $image = Image::make($imagePath);

        $width = $image->width();
        $height = $image->height();

        $newImage = Image::canvas($width, $height, null);

        $backgroundColor = $formData['code'];

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $color = $image->pickColor($x, $y, 'array');
                if($color[0] < 150 && $color[1] < 150 && $color[2] < 150){
                    $newImage->pixel([$color[0],$color[1],$color[2]], $x, $y);
                }
                elseif($color[3] != 0){
                    $newImage->pixel($backgroundColor, $x, $y);
                }

            }
        }



        $newImage->save('storage/tshirt_base/'.$backgroundColor.'.jpg');

        return redirect()->route('color.index')
            ->with('alert-msg', "Cor criada com sucesso")
            ->with('alert-type', 'success');
    }

    public function create()
    {
        $color = new Color();

        return view('color.create', compact('color'));
    }

    public function destroy(string $code): RedirectResponse
    {
        $color = Color::withTrashed()->findOrFail($code);
        if ($color->trashed()){
            $color->forceDelete();
            Storage::disk('tshirt_base')->delete($code.'.jpg');
            return redirect()->back()->with('alert-msg', 'Cor excluída permanentemente com sucesso.')
                ->with('alert-type', 'success');
        }
        if ($color->orderItems != null) {
            return redirect()->back()->with('alert-msg', 'Não é possível excluir a cor pois existem itens de pedido associados a ela.')
                ->with('alert-type', 'erro');
        }
        $color->delete();
        return redirect()->back()->with('alert-msg', 'Cor excluída com sucesso.')
            ->with('alert-type', 'success');
    }

    public function restore(string $code)
    {
        $color = Color::withTrashed()->findOrFail($code);

        $color->restore();
        $color->save();

        return redirect()->back()
            ->with('alert-msg', 'Cor restaurado com sucesso.')
            ->with('alert-type', 'success');
    }

    public function edit(Color $color): View
    {
        $this->authorize('update', $color);
        return view('color.edit')->with('color',$color);
    }

    public function update(ColorRequest $request, Color $color): RedirectResponse
    {
        $formData = $request->validate();

        $color = DB::transaction(function () use ($formData, $color) {
            $color->name = $formData['name'];
            $color->code = $formData['code'];
            $color->save();
            return $color;
        });
        return redirect()->route('color.index')
            ->with('alert-msg', "Cor atualizada com sucesso")
            ->with('alert-type', 'success');
    }
}
