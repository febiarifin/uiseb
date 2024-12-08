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
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($validatedData)) {
            if (Auth::user()->type != User::TYPE_PESERTA) {
                return redirect()->intended('dashboard');
            }else{
                if (Auth::user()->is_email_verified) {
                    // return redirect()->intended('dashboard');
                    return redirect()->intended('notifications');
                }else{
                    auth()->logout();
                    return redirect()->route('login.index')->with('error', 'If you have registered, please verify your email first!');
                }
            }
        }
        Toastr::error('Oppes! You have entered invalid credentials', 'Error', ["positionClass" => "toast-top-right"]);
        return redirect()->route('login.index');
    }

}
