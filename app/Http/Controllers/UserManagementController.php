<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::paginate(10); // angka 10 = jumlah data per halaman

        return view('user-management.index', compact('users'));
    }
}
