<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Abstrak;
use App\Models\Paper;
use App\Models\Penulis;
use App\Models\RevisiAbstrak;
use App\Models\Setting;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AbstrakController extends Controller
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
     * @param  \App\Models\Abstrak  $abstrak
     * @return \Illuminate\Http\Response
     */
    public function show(Abstrak $abstrak)
    {
        $data = [
            'title' => 'Detail Abstrak',
            'subtitle' => null,
            'active' => 'dashboard',
            'abstrak' => $abstrak,
            'revisis' => $abstrak->revisis()->orderBy('created_at', 'desc')->paginate(5),
        ];
        return view('pages.abstrak.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Abstrak  $abstrak
     * @return \Illuminate\Http\Response
     */
    public function edit(Abstrak $abstrak)
    {
        $data = [
            'title' => 'Submit Abstrak',
            'subtitle' => null,
            'active' => 'dashboard',
            'abstrak' => $abstrak,
            'user' => $abstrak->registration->user,
            'setting' => Setting::first(),
        ];
        return view('pages.abstrak.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abstrak  $abstrak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Abstrak $abstrak)
    {
        $validatedData = $request->validate([
            'title' => ['required'],
            'type_paper' => ['required'],
            'keyword' => ['required'],
            'abstract' => ['required'],
            'file' => ['required', 'mimes:docx', 'max:5000'],
        ]);
        // if (count($abstrak->penulis) != 0) {
        //     foreach ($abstrak->penulis as $author) {
        //         $author->delete();
        //     }
        // }
        if ($request->first_names) {
            for ($i = 0; $i < count($request->first_names); $i++) {
                Penulis::create([
                    'first_name' => $request->first_names[$i],
                    'middle_name' => $request->middle_names[$i],
                    'last_name' => $request->last_names[$i],
                    'email' => $request->emails[$i],
                    'affiliate' => $request->affiliates[$i],
                    'coresponding' => $request->corespondings[$i],
                    'degree' => $request->degrees[$i],
                    'address' => $request->address[$i],
                    'research_interest' => $request->research_interests[$i],
                    'abstrak_id' => $abstrak->id,
                ]);
            }
        }
        $validatedData['file'] = AppHelper::upload_file($request->file, 'files');
        $validatedData['status'] = Abstrak::REVIEW;
        $abstrak->update($validatedData);
        if (count($abstrak->users) == 0) {
            $randomReviewer = User::where('type', User::TYPE_REVIEWER)->inRandomOrder()->first();
            $abstrak->users()->attach($randomReviewer->id);
        }
        Toastr::success('Abstrak berhasil disubmit', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Abstrak  $abstrak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Abstrak $abstrak)
    {
        //
    }

    public function review(Abstrak $abstrak)
    {
        $data = [
            'title' => 'Review Abstrak',
            'subtitle' => null,
            'active' => 'dashboard',
            'abstrak' => $abstrak,
            'reviewers' => User::where('type', User::TYPE_REVIEWER)->get(),
            'revisis' => $abstrak->revisis()->orderBy('created_at', 'desc')->paginate(5),
        ];
        return view('pages.abstrak.detail', $data);
    }

    public function reviewerStore(Request $request, $id)
    {
        $abstrak = Abstrak::findOrFail($id);
        $abstrak->users()->sync($request->users);
        Toastr::success('Reviewer berhasil ditugaskan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function reviewerDelete($id)
    {
        DB::table('abstrak_users')->where('id', $id)->delete();
        Toastr::success('Reviewer berhasil dihapus', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function reviewStore(Request $request, $id)
    {
        $abstrak = Abstrak::findOrFail($id);
        $validatedData = $request->validate([
            'note' => ['required'],
            //'status' => ['required'],
            'file' => [
                Rule::requiredIf(function () use ($request) {
                    if (empty($request->file)) {
                        return false;
                    }
                    return true;
                }),
                'mimes:docx,pdf',
                'max:1000'
            ],
        ]);
        if ($request->file) {
            $validatedData['file'] = AppHelper::upload_file($request->file, 'files');
        }
        if (Auth::user()->type == User::TYPE_REVIEWER) {
            $validatedData['status'] = $request->status;
        } else {
            if ($request->status == Abstrak::REVISI_MAYOR || $request->status == Abstrak::REVISI_MINOR) {
                $status = 'REVISI';
            } else if ($request->status == Abstrak::REJECTED) {
                $status = 'REJECTED';
            } else if ($request->status == Abstrak::ACCEPTED) {
                $status = 'ACCEPTED';
            }
            $validatedData['note'] = $validatedData['note'] . '<div>Rekomendasi status: <span class="badge badge-secondary">' . $status . '</span></div>';
        }
        $validatedData['file_abstrak'] = $abstrak->file;
        $validatedData['abstrak_id'] = $abstrak->id;
        $validatedData['user_id'] = Auth::user()->id;
        RevisiAbstrak::create($validatedData);
        if ($request->status && Auth::user()->type == User::TYPE_REVIEWER) {
            if ($validatedData['status'] == Abstrak::REJECTED) {
                AppHelper::create_abstrak($abstrak->registration);
            } else if ($validatedData['status'] == Abstrak::ACCEPTED) {
                AppHelper::create_paper($abstrak);
            }
            $abstrak->update([
                'status' => $validatedData['status'],
                'acc_at' => $validatedData['status'] == Abstrak::ACCEPTED ? now() : null,
            ]);
        }
        Toastr::success('Review abstrak berhasil disimpan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }
}
