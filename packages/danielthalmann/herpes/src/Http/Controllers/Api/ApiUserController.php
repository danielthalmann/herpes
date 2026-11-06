<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use App\Models\User;
use Danielthalmann\Herpes\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->input('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        return $query->paginate($request->input('paginate', 20));
    }

}
