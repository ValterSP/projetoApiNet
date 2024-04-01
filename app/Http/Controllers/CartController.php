<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\OrderRequest;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TshirtImage;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function show(): View
    {
        $price = Price::first();
        $cart = session('cart',[]);
        return view('cart.show', compact('cart','price'));
    }

    public function addToCart(CartRequest $request): RedirectResponse
    {
        try {
            $cart = session('cart',[]);
            $cart[] = $request->validated();
            $request->session()->put('cart', $cart);
            $alertType = 'success';
            $htmlMessage = "Tshirt
                 Adicionada ao carrinho
                 com sucess!";
        }
        catch (\Exception $error){
            $htmlMessage = "Não é possível adicionar a tshirt
            ao carrinho, porque ocorreu um erro!";
            $alertType = 'danger';
        }
        if($request->validated()['private'] == '1')
        {
            return redirect()->back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
        }
        return redirect()->back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);

    }
    public function removeFromCart(Request $request, int $id): RedirectResponse
    {
        $cart = session('cart', []);
        if (array_key_exists($id, $cart)) {
            unset($cart[$id]);
        }
        $request->session()->put('cart', $cart);
        $htmlMessage = "Tshirt foi removida do carrinho!";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function store(OrderRequest $request): RedirectResponse
    {
        try {
            if(Auth::user()->user_type != 'C')
            {
                $alertType = 'warning';
                $htmlMessage = "O utilizador não é cliente, encomendar as tshirts do carrinho";
            }
            else{
                $cart = session('cart', []);
                $total = count($cart);
                if ($total < 1)
                {
                    $alertType = 'warning';
                    $htmlMessage = "Não é possível confirmar a compra porque não existem tshirts no carrinho";
                }
                else
                {
                    $price = Price::first();
                    $formData = $request->validated();
                    $date = Carbon::now();
                    $order = DB::transaction(function () use ($cart,$date,$formData,$price) {
                        $order = new Order();
                        $order->customer_id = Auth::user()->id;
                        $order->date = $date->format('Y-m-d');
                        $order->status = $formData['status'];
                        $order->total_price = $formData['total_price'];
                        $order->notes = $formData['notes'] ?? null;
                        $order->nif = $formData['nif'];
                        $order->address = $formData['address'];
                        $order->payment_type = $formData['payment_type'];
                        $order->payment_ref = $formData['payment_ref'];
                        $order->save();
                        foreach ($cart as $item) {
                            $orderItem = new OrderItem();
                            $orderItem->order_id = $order->id;
                            $orderItem->tshirt_image_id = $item['tshirt_image_id'];
                            $orderItem->color_code = $item['color_code'];
                            $orderItem->size = $item['size'];
                            $orderItem->qty = $item['qty'];
                            if($item['qty'] >= 5){
                                if($item['private'] == '0')
                                {
                                    $orderItem->unit_price = $price->unit_price_catalog_discount;
                                    $orderItem->sub_total = $price->unit_price_catalog_discount * $item['qty'];
                                }
                                else
                                {
                                    $orderItem->unit_price = $price->unit_price_own_discount;
                                    $orderItem->sub_total = $price->unit_price_own_discount * $item['qty'];
                                }

                            }
                            else{
                                if($item['private'] == '0') {
                                    $orderItem->unit_price = $price->unit_price_catalog;
                                    $orderItem->sub_total = $price->unit_price_catalog * $item['qty'];
                                }
                                else{
                                    $orderItem->unit_price = $price->unit_price_own;
                                    $orderItem->sub_total = $price->unit_price_own * $item['qty'];
                                }

                            }
                            $orderItem->save();
                        }
                        return $order;
                    });
                    if ($total == 1) {
                        $htmlMessage = "Foi confirmada a compra de 1 tshirt";
                    } else {
                        $htmlMessage = "Foi confirmada a compra de $total tshirts";
                    }

                    Mail::to(Auth::user()->email)->queue(new OrderMail($order));
                    $request->session()->forget('cart');
                    return redirect()->route('catalogo')
                        ->with('alert-msg', $htmlMessage)
                        ->with('alert-type', 'success');
                }
        }
        }catch (\Exception $error) {
            $htmlMessage = "Não foi possível comprar as tshirts do carrinho, porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        $htmlMessage = "Carrinho está limpo!";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }
}
