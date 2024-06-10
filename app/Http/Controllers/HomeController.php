<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => config('app.name'),
        ];
        return view('pages.public.index', $data);
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
            'active' => 'dashboard',
        ];
        if (Auth::user()->type == User::TYPE_PESERTA) {
            $view = 'pages.dashboard.index-user';
            $data['registrations'] = Auth::user()->registrations()->with(['category'])->orderBy('created_at','desc')->take(5)->get();
        }else{
            $view = 'pages.dashboard.index';
            $data['users'] = User::whereNotIn('type', [User::TYPE_ADMIN])->get();
            $data['registrations'] = Registration::all();
            $data['categories'] = Category::all();
            $data['registrations_validation'] = Registration::with(['category', 'user'])->orderBy('created_at','desc')->where('status', Registration::ACC)->where('is_valid', null)->where('payment_image', '!=', null)->take(5)->get();
            $data['registrations_reviews'] = Registration::with(['category', 'user'])->orderBy('created_at','desc')->where('status', Registration::REVIEW)->take(5)->get();
        }
        return view($view, $data);
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('login.index');
    }
}
