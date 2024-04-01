<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class PDFController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('notCustomer')->only('generatePDF');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF(Order $order)
    {
        $data = [
            'encomenda' => $order,
        ];

        $pdf = PDF::loadView('myPDF', $data);

        $filename = 'receipt_' . time() . '_' . uniqid() . '.pdf';

        $orderUpdate = Order::findOrFail($order->id);

        DB::transaction(function () use ($orderUpdate, $filename) {
            $orderUpdate->receipt_url = $filename;
            $orderUpdate->save();
            return $orderUpdate;
        });
        // Save the PDF using the generated filename in the "storage/app/pdf_receipts" directory
        Storage::put('pdf_receipts/' . $filename, $pdf->output());

    }

    public function show($filename)
    {
        $order = Order::where('receipt_url',$filename)->first();
        if(Auth::user()->id == $order->customer_id || Auth::user()->user_type = 'A')
        {
            $filePath = 'pdf_receipts/' . $filename;
            if (Storage::disk('pdf_receipts')->exists($filePath)) {
                $file = Storage::disk('pdf_receipts')->get($filePath);
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                ];

                return response($file, 200, $headers);
            }
        }
        abort(404);
    }
}
