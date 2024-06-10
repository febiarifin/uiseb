<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        $data = [
            'title' => config('app.name')
        ];
        return view('pages.public.login', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required','email:dns'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($validatedData)) {
            if (Auth::user()->type == User::TYPE_PESERTA) {
                if (Auth::user()->is_email_verified) {
                    return redirect()->intended('dashboard');
                }else{
                    return redirect()->route('login.index')->with('error', 'Please verify your email first!');
                }
            }
            return redirect()->intended('dashboard');
        }
        Toastr::error('Oppes! You have entered invalid credentials', 'Error', ["positionClass" => "toast-top-right"]);
        return redirect()->route('login.index');
    }

}
