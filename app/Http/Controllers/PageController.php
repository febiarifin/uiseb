<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Category;
use App\Models\Page;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Manajemen Halaman',
            'subtitle' => 'Tabel Data Halaman',
            'active' => 'page',
            'pages' => Page::all(),
        ];
        return view('pages.page.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
        ]);
        $page = Page::create($validatedData);
        Toastr::success('Halaman baru berhasil dibuat', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('pages.edit', $page->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        $date = Carbon::parse($page->date);
        $data = [
            'title' => 'PREVIEW: '. $page->name,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $data = [
            'title' => 'Edit Halaman',
            'subtitle' => null,
            'active' => 'page',
            'page' => Page::with(['timelines','contacts','articles','speakers'])->where('id', $page->id)->first(),
        ];
        return view('pages.page.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'theme' => ['required'],
            'date' => ['required'],
            'about_1' => ['required'],
            'about_2' => ['required'],
            'image_1' => [Rule::requiredIf(function () {
                if (empty($this->request->image_1)) {
                    return false;
                }
                return true;
            }), 'mimes:jpg,png,jpeg', 'max:1000'],
            'image_2' => [Rule::requiredIf(function () {
                if (empty($this->request->image_1)) {
                    return false;
                }
                return true;
            }), 'mimes:jpg,png,jpeg', 'max:1000'],
            'image_3' => [Rule::requiredIf(function () {
                if (empty($this->request->image_1)) {
                    return false;
                }
                return true;
            }), 'mimes:jpg,png,jpeg', 'max:1000'],
            'scope' => ['required'],
            'submission' => ['required'],
        ]);
        if ($request->image_1) {
            AppHelper::delete_file($page->image_1);
            $validatedData['image_1'] = AppHelper::upload_file($request->image_1,'images');
        }
        if ($request->image_2) {
            AppHelper::delete_file($page->image_2);
            $validatedData['image_2'] = AppHelper::upload_file($request->image_2,'images');
        }
        if ($request->image_3) {
            AppHelper::delete_file($page->image_3);
            $validatedData['image_3'] = AppHelper::upload_file($request->image_3,'images');
        }
        $page->update($validatedData);
        Toastr::success('Update berhasil disimpan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $check_page = Page::whereNotIn('id', [$page->id])->get();
        if (count($check_page) == 0) {
            Toastr::warning('Harus ada halaman yang aktif', 'Success', ["positionClass" => "toast-top-right"]);
            return back();
        }
        $page->delete();
        Toastr::success('Halaman berhasil dihapus', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function change(Page $page)
    {
        $check_page = Page::where('status', Page::ENABLE)->whereNotIn('id', [$page->id])->get();
        if(count($check_page) > 0){
            Toastr::warning('Sudah ada halaman yang aktif', 'Success', ["positionClass" => "toast-top-right"]);
            return back();
        }
        $page->update([
            'status' => $page->status == Page::DISABLE ? Page::ENABLE : Page::DISABLE,
        ]);
        Toastr::success($page->status == Page::DISABLE ? 'Halaman baru berhasil diaktifkan' : 'Halaman baru berhasil dinonaktifkan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

}
