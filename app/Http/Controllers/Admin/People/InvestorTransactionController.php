<?php

namespace App\Http\Controllers\Admin\People;

use App\Http\Controllers\Controller;
use App\Models\Admin\People\InvestorTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvestorTransactionController extends Controller
{
    public function index($investorId)
    {
        $transactions = InvestorTransaction::where('investor_id', $investorId)->with('candidate')->latest()->get();
        return response()->json($transactions);
    }

    public function store(Request $request, $investorId)
    {
        $data = $request->validate([
            'transaction_type' => 'required|string',
            'payment_method' => 'required|string',
            'currency' => 'required|string',
            'amount' => 'required|numeric',
            'bdt_amount' => 'required|numeric',
            'candidate_id' => 'nullable|exists:candidates,id',
            'attachment' => 'nullable|file',
            'transaction_note' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
        $data['investor_id'] = $investorId;
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('investor_attachments', 'public');
        }
        $transaction = InvestorTransaction::create($data);
        return response()->json($transaction, 201);
    }
}
