<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\Account;
use Illuminate\Http\Request;

class ApiAccountController extends Controller
{
    public function index(Request $request)
    {
        $query = Account::query();

        if ($request->input('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('name', 'like', '%' . $request->input('search') . '%');
            });
        }

        return $query->orderBy('code')->paginate($request->input('paginate', 20));
    }

    public function store(Request $request)
    {
        $account = new Account();
        $account->code = $request->input('code');
        $account->name = $request->input('name');
        $account->save();

        return $account;
    }

    /**
     * Create the specified resource.
     */
    public function create()
    {
        $account = new Account();

        return $account;
    }

    public function show(string $id)
    {
        return Account::query()->find($id);
    }

    public function update(Request $request, string $id)
    {
        $account = Account::query()->find($id);

        if ($account) {
            $account->code = $request->input('code');
            $account->name = $request->input('name');
            $account->save();
        }

        return $account;
    }

    public function destroy(string $id)
    {
        $account = Account::query()->find($id);
        if ($account) {
            $account->delete();
        }
        return $account;
    }
}
