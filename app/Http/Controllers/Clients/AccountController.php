<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // app/Http/Controllers/Clients/AccountController.php

public function index()
{
    $user = Auth::user(); 
    return view('clients.pages.profile', compact('user'));
}
}
