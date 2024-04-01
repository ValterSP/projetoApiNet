<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TshirtImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstatisticaController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $totalGanho = Order::sum('total_price');
        $totalTshirts = OrderItem::sum('qty');
        $vendasPorMes = Order::selectRaw('MONTH(date) as mes,YEAR(date) as ano, SUM(total_price) as total')
            ->groupBy('mes', 'ano')
            ->orderBy('ano', 'asc')
            ->orderBy('mes', 'asc')
            ->get();

        $tshirtMaisVendida = OrderItem::select('tshirt_image_id', DB::raw('SUM(qty) as quantidade'))
            ->groupBy('tshirt_image_id')
            ->orderByDesc('quantidade')
            ->first();


        $corMaisVendida = OrderItem::select('color_code', DB::raw('SUM(qty) as quantidade'))
            ->groupBy('color_code')
            ->orderByDesc('quantidade')
            ->first();

        $labels = $vendasPorMes->map(function ($venda) {
            return $venda->mes . '/' . $venda->ano;
        });
        $valores = $vendasPorMes->pluck('total');


        return view('estatistica.index', compact('valores','labels','totalGanho','totalTshirts','tshirtMaisVendida', 'corMaisVendida'));
    }
}
