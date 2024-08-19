<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Page;
use App\Models\Speaker;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'image' => [Rule::requiredIf(function () {
                if (empty($this->request->image)) {
                    return false;
                }
                return true;
            }), 'mimes:jpg,png,jpeg', 'max:1000'],
            'logo' => [Rule::requiredIf(function () {
                if (empty($this->request->logo)) {
                    return false;
                }
                return true;
            }), 'mimes:jpg,png,jpeg', 'max:1000'],
            'name' => ['required'],
            'description' => ['required'],
            'institution' => ['required'],
            'is_keynote' => ['required'],
            'page_id' => ['required'],
        ]);
        if ($request->image) {
            $validatedData['image'] = AppHelper::upload_file($request->image,'images');
        }
        if ($request->logo) {
            $validatedData['logo'] = AppHelper::upload_file($request->logo,'images');
        }
        Speaker::create($validatedData);
        Toastr::success('Speaker berhasil ditambahkan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function show(Speaker $speaker)
    {
        $page = Page::where('status', Page::ENABLE)->whereYear('created_at', now())->first();
        if (!$page) {
            $page = Page::first();
        }
        $data = [
            'title' => $speaker->name,
            'page' => $page,
            'speaker' => $speaker,
        ];
        return view('pages.public.speaker-detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function edit(Speaker $speaker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speaker $speaker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speaker $speaker)
    {
        AppHelper::delete_file($speaker->image);
        $speaker->delete();
        Toastr::success('Speaker berhasil dihapus', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }
}
