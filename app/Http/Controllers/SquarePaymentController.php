<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nikolag\Square\Facades\Square;

class SquarePaymentController extends Controller
{
    public function create()
    {
        return view('payment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nonce' => 'required',
        ]);

        $options = [
            'amount' => 100,
            'source_id' => $request->nonce,
            'location_id' => env('SQUARE_LOCATION_ID') ?? null,
            'currency' => 'USD',
            'note' => 'This is a test transaction',
            'reference_id' => 12
        ];

        Square::charge($options);

        session()->flash('status', 'Transaction Successful!');
        return redirect()->route('home');
    }
}