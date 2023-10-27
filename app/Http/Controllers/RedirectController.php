<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function cek()
    {
        $user = auth()->user();

        if ($user->role_id === 1) {
            return redirect('/admin');
        } elseif ($user->role_id === 2) {
            return redirect('/user');
        } else {
            return redirect('/admin');
        }
    }
}
