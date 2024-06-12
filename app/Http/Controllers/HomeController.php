<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $page = Page::with(['timelines','contacts','speakers','articles'])->where('status', Page::ENABLE)->whereYear('created_at', now())->first();
        if (!$page) {
            $page = Page::with(['timelines','contacts','speakers','articles'])->first();
        }
        $date = Carbon::parse($page->date);
        $data = [
            'title' => config('app.name'),
            'page' => $page,
            'categories' => Category::all(),
            'editors' => User::where('type', User::TYPE_EDITOR)->get(),
            'committees' => User::where('type', User::TYPE_COMMITTEE)->get(),
            'month' => $date->month,
            'day' => $date->day,
            'year' => $date->year,
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
