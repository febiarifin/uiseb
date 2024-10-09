<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
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
        $deadline_date = Carbon::parse($page->date);
        $data = [
            'title' => config('app.name'),
            'page' => $page,
            'categories' => $page->categories()->where('is_active', Category::IS_ACTIVE)->get(),
            'editors' => User::where('type', User::TYPE_EDITOR)->orWhere('type', User::TYPE_REVIEWER)->get(),
            'committees' => User::where('type', User::TYPE_COMMITTEE)->get(),
            'month' => $deadline_date->month,
            'day' => $deadline_date->day,
            'year' => $deadline_date->year,
            'setting' => Setting::first(),
            'deadline_date' => $deadline_date->format('Ymd'),
        ];
        return view('pages.public.index', $data);
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'setting' => Setting::first(),
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
            if (Auth::user()->type == User::TYPE_ADMIN || Auth::user()->type == User::TYPE_SUPER_ADMIN) {
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
                        ->where('status', Abstrak::REVIEW)
                        // ->where('status', '!=', null)
                        ->get();
                    $data['papers'] = Paper::orderBy('created_at', 'desc')
                        ->where('status', Paper::REVIEW_EDITOR)
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
    public function about()
    {
        $page = Page::where('status', Page::ENABLE)->whereYear('created_at', now())->first();
        if (!$page) {
            $page = Page::first();
        }
        $data = [
            'title' => config('app.name'),
            'page' => $page,
        ];
        return view('pages.public.about', $data);
    }

    public function conference()
    {
        $page = Page::where('status', Page::ENABLE)->whereYear('created_at', now())->first();
        if (!$page) {
            $page = Page::first();
        }
        $data = [
            'title' => config('app.name'),
            'page' => $page,
            'categories' => $page->categories()->where('is_active', Category::IS_ACTIVE)->get(),
            'editors' => User::where('type', User::TYPE_EDITOR)->get(),
            'committees' => User::where('type', User::TYPE_COMMITTEE)->get(),
            'setting' => Setting::first(),
        ];
        return view('pages.public.conference', $data);
    }

    public function author()
    {
        $page = Page::where('status', Page::ENABLE)->whereYear('created_at', now())->first();
        if (!$page) {
            $page = Page::first();
        }
        $data = [
            'title' => 'Author Instruction',
            'page' => $page,
        ];
        return view('pages.public.author', $data);
    }

    public function template()
    {
        $page = Page::where('status', Page::ENABLE)->whereYear('created_at', now())->first();
        if (!$page) {
            $page = Page::first();
        }
        $data = [
            'title' => 'Template Word',
            'page' => $page,
        ];
        return view('pages.public.template', $data);
    }

    public function accessEditor()
    {
        $data = [
            'title' => 'Akses Editor',
            'active' => 'editor',
            'setting' => Setting::first(),
        ];
        $view = 'pages.dashboard.index-ojs';
        $data['abstraks'] = Abstrak::orderBy('created_at', 'desc')
            ->where('status', Abstrak::REVIEW)
            // ->where('status', '!=', null)
            ->get();
        $data['papers'] = Paper::orderBy('created_at', 'desc')
            ->where('status', Paper::REVIEW_EDITOR)
            // ->where('status', '!=', null)
            ->get();
        $data['videos'] = Video::orderBy('created_at', 'desc')
            ->where('status', Video::REVIEW)
            // ->where('status', '!=', null)
            ->get();
        $data['users'] = User::whereNotIn('type', [User::TYPE_ADMIN])->get();
        $data['categories'] = Category::all();
        $data['registrations_validation'] = Registration::with(['category', 'user'])->orderBy('created_at', 'desc')
            // ->where('is_valid', null)
            // ->where('payment_image', '!=', null)
            // ->take(5)
            ->get();
        return view($view, $data);
    }

    public function accessReviewer()
    {
        $data = [
            'title' => 'Akses Reviewer',
            'active' => 'reviewer',
            'setting' => Setting::first(),
        ];
        $view = 'pages.dashboard.index-ojs';
        $data['abstraks'] = Abstrak::orderBy('created_at', 'desc')
            ->where('status', Abstrak::REVIEW)
            ->get();
        $data['papers'] = Paper::orderBy('created_at', 'desc')
            ->where('status', Paper::REVIEW)
            ->get();
        $data['videos'] = Video::orderBy('created_at', 'desc')
            ->where('status', Video::REVIEW)
            ->get();
        $data['users'] = User::whereNotIn('type', [User::TYPE_ADMIN])->get();
        $data['categories'] = Category::all();
        $data['registrations_validation'] = Registration::with(['category', 'user'])->orderBy('created_at', 'desc')
            // ->where('is_valid', null)
            // ->where('payment_image', '!=', null)
            // ->take(5)
            ->get();
        return view($view, $data);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login.index');
    }
}
