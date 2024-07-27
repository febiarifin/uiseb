<?php

namespace App\Http\Controllers;

use App\Models\Abstrak;
use App\Models\Category;
use App\Models\Page;
use App\Models\Paper;
use App\Models\Registration;
use App\Models\Setting;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $page = Page::with(['timelines', 'contacts', 'speakers', 'articles'])->where('status', Page::ENABLE)->whereYear('created_at', now())->first();
        if (!$page) {
            $page = Page::with(['timelines', 'contacts', 'speakers', 'articles'])->first();
        }
        $date = Carbon::parse($page->date);
        $data = [
            'title' => config('app.name'),
            'page' => $page,
            'categories' => $page->categories()->where('is_active', Category::IS_ACTIVE)->get(),
            'editors' => User::where('type', User::TYPE_EDITOR)->get(),
            'committees' => User::where('type', User::TYPE_COMMITTEE)->get(),
            'month' => $date->month,
            'day' => $date->day,
            'year' => $date->year,
            'setting' => Setting::first(),
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
            // $view = 'pages.dashboard.index-user';
            $registrations = Auth::user()->registrations()
            ->with([
                'category',
                'abstraks' => function ($query) {
                    $query->with([
                        'papers' => function ($query) {
                            $query->with('videos');
                        }
                    ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();
            $view = 'pages.dashboard.index-ojs';
            $data['registrations'] = $registrations;
        } else {
            if (Auth::user()->type == User::TYPE_ADMIN) {
                $view = 'pages.dashboard.index';
                $data['registrations'] = Registration::all();
            } else {
                $view = 'pages.dashboard.index-ojs';
                if (Auth::user()->type == User::TYPE_REVIEWER) {
                    $data['abstraks'] = Auth::user()->abstraks()
                        ->orderBy('created_at', 'desc')->where('status', Abstrak::REVIEW)
                        ->get();
                    $data['papers'] = Auth::user()->papers()
                        ->orderBy('created_at', 'desc')->where('status', Paper::REVIEW)
                        ->get();
                } else {
                    $data['abstraks'] = Abstrak::orderBy('created_at', 'desc')
                        ->where('status', Abstrak::ACCEPTED)
                        ->get();
                    $data['papers'] = Paper::orderBy('created_at', 'desc')
                        ->where('status', Paper::ACCEPTED)
                        ->get();
                    $data['videos'] = Video::orderBy('created_at', 'desc')
                        ->where('status', Video::REVIEW)
                        ->get();
                }
            }
            $data['users'] = User::whereNotIn('type', [User::TYPE_ADMIN])->get();
            $data['categories'] = Category::all();
            $data['registrations_validation'] = Registration::with(['category', 'user'])->orderBy('created_at', 'desc')
                ->where('is_valid', null)
                ->where('payment_image', '!=', null)
                ->take(5)
                ->get();
            // $data['registrations_reviews'] = Registration::with(['category', 'user'])
            // ->orderBy('created_at','desc')
            // ->where('status', Registration::REVIEW)
            // ->take(5)
            // ->get();
        }
        return view($view, $data);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login.index');
    }
}
