<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Paper;
use App\Models\RevisiPaper;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
            'revisis' => $paper->revisis()->orderBy('created_at', 'desc')->paginate(5),
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
        if (count($paper->users) == 0) {
            $randomReviewer = User::where('type', User::TYPE_REVIEWER)->inRandomOrder()->first();
            $paper->users()->attach($randomReviewer->id);
        }
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

    public function review(Paper $paper)
    {
        $data = [
            'title' => 'Review Paper',
            'subtitle' => null,
            'active' => 'dashboard',
            'paper' => $paper,
            'reviewers' => User::where('type', User::TYPE_REVIEWER)->get(),
            'revisis' => $paper->revisis()->orderBy('created_at', 'desc')->paginate(5),
        ];
        return view('pages.paper.detail', $data);
    }

    public function reviewerStore(Request $request, $id)
    {
        $paper = Paper::findOrFail($id);
        $paper->users()->sync($request->users);
        Toastr::success('Reviewer berhasil ditugaskan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function reviewerDelete($id)
    {
        DB::table('paper_users')->where('id', $id)->delete();
        Toastr::success('Reviewer berhasil dihapus', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function reviewStore(Request $request, $id)
    {
        $paper = Paper::findOrFail($id);
        $validatedData = $request->validate([
            'note' => ['required'],
            //'status' => ['required'],
            'file' => [Rule::requiredIf(function () use($request) {
                if (empty($request->file)) {
                    return false;
                }
                return true;
            }), 'mimes:docx,pdf', 'max:1000'],
        ]);
        if ($request->file) {
            $validatedData['file'] = AppHelper::upload_file($request->file, 'files');
        }
        $validatedData['status'] = $request->status;
        $validatedData['file_paper'] = $paper->file;
        $validatedData['paper_id'] = $paper->id;
        $validatedData['user_id'] = Auth::user()->id;
        RevisiPaper::create($validatedData);
        if ($request->status) {
            if ($validatedData['status'] == Paper::REJECTED) {
                AppHelper::create_paper($paper->abstrak);
            }else if ($validatedData['status'] == Paper::ACCEPTED) {
                AppHelper::create_video($paper);
            }
            $paper->update([
                'status' => $validatedData['status'],
                'acc_at' => $validatedData['status'] == Paper::ACCEPTED ? now() : null,
            ]);
        }
        Toastr::success('Review paper berhasil disimpan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }
}
