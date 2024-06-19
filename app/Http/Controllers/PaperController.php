<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Paper;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class PaperController extends Controller
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
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function show(Paper $paper)
    {
        $data = [
            'title' => 'Detail Paper',
            'subtitle' => null,
            'active' => 'dashboard',
            'paper' => $paper,
            // 'revisis' => $paper->revisis()->orderBy('created_at', 'desc')->paginate(5),
        ];
        return view('pages.paper.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function edit(Paper $paper)
    {
        $data = [
            'title' => 'Submit Paper',
            'subtitle' => null,
            'active' => 'dashboard',
            'paper' => $paper,
        ];
        return view('pages.paper.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paper $paper)
    {
        $validatedData = $request->validate([
            'abstract' => ['required'],
            'bibliography' => ['required'],
            'keyword' => ['required'],
            'file' => ['required','mimes:docx','max:5000'],
        ]);
        $validatedData['file'] = AppHelper::upload_file($request->file, 'files');
        $validatedData['status'] = Paper::REVIEW;
        $paper->update($validatedData);
        Toastr::success('Paper berhasil disubmit', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paper $paper)
    {
        //
    }
}
