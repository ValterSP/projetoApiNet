<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use Illuminate\Http\Request;
use App\Models\Price;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PriceController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }

    public function edit(): View
    {
        $price = Price::first();
        return view('price.edit', compact('price'));
    }

    public function update(PriceRequest $request)
    {
        $price = Price::first();
        $formData = $request->validated();
        DB::transaction(function () use ($formData, $price){
            $price->unit_price_catalog = $formData['unit_price_catalog'];
            $price->unit_price_catalog_discount = $formData['unit_price_catalog_discount'];
            $price->qty_discount = $formData['qty_discount'];
            $price->unit_price_own = $formData['unit_price_own'];
            $price->unit_price_own_discount = $formData['unit_price_own_discount'];
            $price->save();
        });

        return redirect()->route('catalogo')
            ->with('alert-msg', "Preço atualizado com sucesso")
            ->with('alert-type', 'success');

    }
}
