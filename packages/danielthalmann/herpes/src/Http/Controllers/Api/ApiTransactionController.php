<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\Transaction;
use Illuminate\Http\Request;

class ApiTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->input('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('accounting_text', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('account_text', 'like', '%' . $request->input('search') . '%');
            });
        }
        $query->orderBy($request->input('sort_by', 'date'), $request->input('sort_order', 'desc'));
        $transactions = $query->paginate($request->input('paginate', 20));
        $transactions->each(function ($transaction) {
            $transaction->debit = $transaction->debit / 100;
            $transaction->credit = $transaction->credit / 100;
        });
        return $transactions;
        
    }

    public function store(Request $request)
    {
        $transaction = new Transaction();
        $transaction->date = $request->input('date');
        $transaction->transaction_group = $request->input('transaction_group');
        $transaction->user_id = $request->input('user_id');
        $transaction->user_name = $request->input('user_name');
        $transaction->account_from_id = $request->input('account_from_id');
        $transaction->account_to_id = $request->input('account_to_id');
        $transaction->invoice_id = $request->input('invoice_id');
        $transaction->accounting_text = $request->input('accounting_text');
        $transaction->tax_code = $request->input('tax_code');
        $transaction->tax_rate = $request->input('tax_rate');
        $transaction->tax_value = $request->input('tax_value');
        $transaction->debit = $request->input('debit') 
            ? $request->input('debit') * 100
            : 0;
        $transaction->credit = $request->input('credit')
            ? $request->input('credit') * 100
            : 0;
        $transaction->save();

        return $transaction;
    }

    /**
     * Create the specified resource.
     */
    public function create()
    {
        $transaction = new Transaction();

        return $transaction;
    }

    public function show(string $id)
    {
        return Transaction::query()->find($id);
    }

    public function update(Request $request, string $id)
    {
        $transaction = Transaction::query()->find($id);

        if ($transaction) {
            $transaction->date = $request->input('date');
            $transaction->transaction_group = $request->input('transaction_group');
            $transaction->user_id = $request->input('user_id');
            $transaction->user_name = $request->input('user_name');
            $transaction->account_from_id = $request->input('account_from_id');
            $transaction->account_to_id = $request->input('account_to_id');
            $transaction->invoice_id = $request->input('invoice_id');
            $transaction->accounting_text = $request->input('accounting_text');
            $transaction->tax_code = $request->input('tax_code');
            $transaction->tax_rate = $request->input('tax_rate');
            $transaction->tax_value = $request->input('tax_value');
            $transaction->debit = $request->input('debit')
                ? $request->input('debit') * 100
                : 0;
            $transaction->credit = $request->input('credit')
                ? $request->input('credit') * 100
                : 0;
            $transaction->save();
        }

        return $transaction;
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::query()->find($id);
        if ($transaction) {
            $transaction->delete();
        }
        return $transaction;
    }
}
