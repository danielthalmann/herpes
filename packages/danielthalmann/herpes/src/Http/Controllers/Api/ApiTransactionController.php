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

        return $query->paginate($request->input('paginate', 20));
    }

    public function store(Request $request)
    {
        $transaction = new Transaction();
        $transaction->date = $request->input('date');
        $transaction->transaction_group = $request->input('transaction_group');
        $transaction->user_id = $request->input('user_id');
        $transaction->user_name = $request->input('user_name');
        $transaction->account_id = $request->input('account_id');
        $transaction->account_text = $request->input('account_text');
        $transaction->invoice_id = $request->input('invoice_id');
        $transaction->accounting_text = $request->input('accounting_text');
        $transaction->tax_code = $request->input('tax_code');
        $transaction->tax_rate = $request->input('tax_rate');
        $transaction->tax_value = $request->input('tax_value');
        $transaction->debit = $request->input('debit');
        $transaction->credit = $request->input('credit');
        $transaction->save();

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
            $transaction->account_id = $request->input('account_id');
            $transaction->account_text = $request->input('account_text');
            $transaction->invoice_id = $request->input('invoice_id');
            $transaction->accounting_text = $request->input('accounting_text');
            $transaction->tax_code = $request->input('tax_code');
            $transaction->tax_rate = $request->input('tax_rate');
            $transaction->tax_value = $request->input('tax_value');
            $transaction->debit = $request->input('debit');
            $transaction->credit = $request->input('credit');
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
