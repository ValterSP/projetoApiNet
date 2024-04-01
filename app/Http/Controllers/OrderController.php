<?php

namespace App\Http\Controllers;

use App\Mail\CanceledOrderMail;
use App\Mail\ClosedOrderMail;
use App\Models\Price;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Order;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('notCustomer')->only('index');
        $this->middleware('customer')->only('show');
        $this->middleware('admin')->only('cancel');
    }

    public function index(Request $request): View
    {

        $filterByUser = $request->user ?? '';
        $filterByStatus = $request->status ?? '';
        $filterByDateMin = $request->dateMin ?? '';
        $filterByDateMax = $request->dateMax ?? '';
        $dataAtual = date('Y-m-d');
        $users = User::has('customer.order')->orderBy('name')->get();
        $orderQuerry = Order::query();
        if($filterByUser !== '')
        {
            $orderQuerry->where('customer_id', $filterByUser);
        }
        if($filterByDateMin !== '' && $filterByDateMax !== '')
        {
            $orderQuerry->whereBetween('date',[$filterByDateMin,$filterByDateMax]);
        }
        if ($filterByStatus !== '')
        {
            $orderQuerry->where('status',$filterByStatus);
        }
        if(Auth::user()->user_type == 'E')
        {
            $encomendas = $orderQuerry->whereIn('status',['paid','pending'])->with('orderItem.tshirtImage')->orderBy('date','desc')->paginate(20);
        }
        else{
            $encomendas = $orderQuerry->with('orderItem.tshirtImage')->orderBy('date','desc')->paginate(20);
        }

        return view('order.index', compact('encomendas','filterByStatus','filterByDateMin','filterByUser', 'filterByDateMax', 'dataAtual', 'users'));
    }

    public function show(Request $request)
    {
        $preco = Price::first();
        $filterByStatus = $request->status ?? '';
        $filterByDateMin = $request->dateMin ?? '';
        $filterByDateMax = $request->dateMax ?? '';
        $dataAtual = date('Y-m-d');
        $orderQuerry = Order::query();
        if($filterByDateMin !== '' && $filterByDateMax !== '')
        {
            $orderQuerry->whereBetween('date',[$filterByDateMin,$filterByDateMax]);
        }
        if ($filterByStatus !== '')
        {
            $orderQuerry->where('status',$filterByStatus);
        }
        $clienteOrders = $orderQuerry->where('customer_id', Auth::user()->customer->id)->with('orderItem.tshirtImage')->orderBy('date','desc')->paginate(20);
        return view('order.show', compact('clienteOrders', 'preco', 'filterByStatus','filterByDateMin', 'filterByDateMax', 'dataAtual'));
    }

    public function mudarEstado(int $orderId, string $status)
    {
        $encomenda = Order::findOrFail($orderId);
        DB::transaction(function () use ($encomenda, $status){
            $encomenda->status = $status;
            $encomenda->save();
        });
        if($encomenda->status == 'closed')
        {
            $pdfController = app(PDFController::class);
            $pdfController->generatePDF($encomenda);
            $encomenda = Order::findOrFail($orderId);
            Mail::to(Auth::user()->email)->queue(new ClosedOrderMail($encomenda));
        }


        return redirect()->back()
            ->with('alert-msg', "Encomenda atualizada com sucesso")
            ->with('alert-type', 'success');
    }

    public function cancel(int $orderId)
    {
        $encomenda = Order::findOrFail($orderId);
        DB::transaction(function () use ($encomenda){
            $encomenda->status = 'canceled';
            $encomenda->save();
        });
        Mail::to(Auth::user()->email)->queue(new CanceledOrderMail($encomenda));
        return redirect()->back()
            ->with('alert-msg', "Encomenda cancelada com sucesso")
            ->with('alert-type', 'success');
    }
}
