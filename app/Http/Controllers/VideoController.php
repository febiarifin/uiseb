<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\RevisiVideo;
use App\Models\Setting;
use App\Models\Video;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        $data = [
            'title' => 'Detail Video',
            'subtitle' => null,
            'active' => 'dashboard',
            'video' => $video,
            'revisis' => $video->revisis()->orderBy('created_at', 'desc')->paginate(5),
        ];
        return view('pages.video.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $data = [
            'title' => 'Submit Video',
            'subtitle' => null,
            'active' => 'dashboard',
            'video' => $video,
            'setting' => Setting::first(),
        ];
        return view('pages.video.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $validatedData = $request->validate([
            'link' => ['required'],
        ]);
        $validatedData['status'] = Video::REVIEW;
        $video->update($validatedData);
        Toastr::success('Video berhasil disubmit', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        //
    }

    public function review(Video $video)
    {
        $data = [
            'title' => 'Review Video',
            'subtitle' => null,
            'active' => 'dashboard',
            'video' => $video,
            'revisis' => $video->revisis()->orderBy('created_at', 'desc')->paginate(5),
        ];
        return view('pages.video.detail', $data);
    }

    public function reviewStore(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $validatedData = $request->validate([
            'note' => ['required'],
            'status' => ['required'],
        ]);
        $validatedData['link'] = $video->link;
        $validatedData['video_id'] = $video->id;
        $validatedData['user_id'] = Auth::user()->id;
        RevisiVideo::create($validatedData);
        if ($validatedData['status'] == Video::REJECTED) {
            AppHelper::create_video($video->paper);
        }
        $video->update([
            'status' => $validatedData['status'],
            'acc_at' => $validatedData['status'] == Video::ACCEPTED ? now() : null,
        ]);
        Toastr::success('Review video berhasil disimpan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }
}
