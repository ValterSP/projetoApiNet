<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tshirtsMaisVendidas = OrderItem::join('tshirt_images', 'order_items.tshirt_image_id', '=', 'tshirt_images.id')
            ->whereNull('tshirt_images.customer_id')
            ->whereNull('tshirt_images.deleted_at')
            ->selectRaw('SUM(order_items.qty) as total_qty, order_items.tshirt_image_id, tshirt_images.image_url, tshirt_images.name, tshirt_images.description')
            ->groupBy('order_items.tshirt_image_id')
            ->orderByDesc('total_qty')
            ->take(20)
            ->get();

        $preco = Price::first();
        return view('home', compact('preco', 'tshirtsMaisVendidas'));
    }
}
