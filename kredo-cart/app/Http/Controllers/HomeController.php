<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->role === User::ADMIN_ROLE_ID) {
            return redirect()->route('admin.products.index');
        }

        return redirect()->route('products.index');
    }
}
