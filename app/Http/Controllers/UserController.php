<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('administration.users.index', compact('users'));
    }

    public function create()
    {
        return view('administration.users.create');
    }

    // Add other CRUD methods...
}