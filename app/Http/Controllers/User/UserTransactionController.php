<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->transactions();

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $direction = $request->get('direction', 'desc');

        $allowed = ['created_at', 'amount', 'type', 'category'];
        if (!in_array($sortBy, $allowed)) {
            $sortBy = 'created_at';
        }
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        $transactions = $query->orderBy($sortBy, $direction)->paginate(10)->withQueryString();

        return view('user.transactions.index', compact('transactions', 'sortBy', 'direction'));
    }
}
