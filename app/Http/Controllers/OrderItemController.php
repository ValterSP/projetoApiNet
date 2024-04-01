<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemRequest;
use App\Models\Price;
use App\Models\TshirtImage;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class OrderItemController extends Controller
{
    public function index()
    {
        $allOrderItems = OrderItem::paginate(20);
        return view('orderItem.index')->with('orderItems', $allOrderItems);
    }

    public function store(OrderItemRequest $request)
    {
        $formData = $request->validated();
        $price = Price::first();
        $newOrderItem = DB::transaction(function () use ($formData, $price)
        {
            $newOrderItem = new OrderItem();
            $newOrderItem->order_id = null;
            $newOrderItem->tshirt_image_id = $formData['tshirt_image_id'];
            $newOrderItem->color_code = $formData['color_code'];
            $newOrderItem->size = $formData['size'];
            $newOrderItem->qty = $formData['qty'];
            $newOrderItem->unit_price = $price->unit_price_catalog;
            $newOrderItem->sub_total = $formData['qty'] * $price->unit_price_catalog;
            $newOrderItem->save();
            return $newOrderItem;
        });

        return route('cart.add', ['orderItem' => $newOrderItem]);
    }
}
