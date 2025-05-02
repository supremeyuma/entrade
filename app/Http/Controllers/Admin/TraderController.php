<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TraderController extends Controller
{
    public function index()
    {
        return view('admin.traders.index');
    }

    public function create()
    {
        return view('admin.traders.create');
    }

    public function store(Request $request)
    {
        // To-do: store logic
    }

    public function edit($id)
    {
        return view('admin.traders.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // To-do: update logic
    }

    public function destroy($id)
    {
        // To-do: delete logic
    }
}
