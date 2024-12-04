<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Paper;
use App\Models\RevisiPaper;
use App\Models\Setting;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
            'setting' => Setting::first(),
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
            // 'abstract' => ['required'],
            'bibliography' => ['required'],
            'keyword' => ['required'],
            'file' => ['required', 'mimes:docx', 'max:5000'],
        ]);
        $validatedData['file'] = AppHelper::upload_file($request->file, 'files');
        $validatedData['abstract'] = $paper->abstrak->abstract;
        $validatedData['keyword'] = $paper->abstrak->keyword;
        $is_accepeted_turnitin = $paper->revisis()->where('is_accepted_turnitin', 1)->first();
        if ($is_accepeted_turnitin) {
            $validatedData['status'] = Paper::REVIEW;
        }else{
            $validatedData['status'] = Paper::REVIEW_EDITOR;
        }
        $paper->update($validatedData);
        if (count($paper->users) == 0) {
            $randomReviewer = User::where('type', User::TYPE_REVIEWER)->inRandomOrder()->first();
            $paper->users()->attach($randomReviewer->id);
        }
        try {
            Mail::send('emails.submission-received', [
                'user' => $paper->abstrak->registration->user,
                'abstrak' => $paper->abstrak,
                'paper' => $paper,
            ], function ($message) use ($paper) {
                $message->to($paper->abstrak->registration->user->email);
                $message->subject('Submission Received');
                $message->attach(public_path($paper->file));
            });
        } catch (\Exception $e) {
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
            'comments' => Paper::COMMENTS,
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
            // 'note' => ['required'],
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
            for ($i = 0; $i < count(Paper::COMMENTS); $i++) {
                $notes[] = "<label>" . Paper::COMMENTS[$i] . "<br><b>" . $request->comments[$i] . "</b></label><br><br>";
            }
            $validatedData['note'] = implode("", $notes);
        } else {
            $validatedData['note'] = $request->note;
            if ($request->status == Paper::REVISI_MAYOR || $request->status == Paper::REVISI_MINOR) {
                $status = 'NOT ACCEPTED CHECK TURNITIN';
            } else if ($request->status == Paper::REVIEW) {
                $status = 'ACCEPTED CHECK TURNITIN';
                $validatedData['is_accepted_turnitin'] = 1;
            }
            $validatedData['note'] = $validatedData['note'] . '<div>Result Turnitin Check: <span class="badge badge-warning">' . $request->result . '%</span></div>' . '<div>Status: <span class="badge badge-info">' . $status . '</span></div>';
            $validatedData['status'] = $request->status;
        }
        $validatedData['file_paper'] = $paper->file;
        $validatedData['paper_id'] = $paper->id;
        $validatedData['user_id'] = Auth::user()->id;
        RevisiPaper::create($validatedData);
        $paper->update([
            'status' => $validatedData['status'],
            'acc_at' => $validatedData['status'] == Paper::ACCEPTED ? now() : null,
        ]);
        // if ($request->status && Auth::user()->type == User::TYPE_REVIEWER) {
        if ($validatedData['status'] == Paper::REJECTED) {
            AppHelper::create_paper($paper->abstrak);
        } else if ($validatedData['status'] == Paper::ACCEPTED) {
            AppHelper::create_video($paper);
            try {
                Mail::send('emails.submission-accepted', [
                    'user' => $paper->abstrak->registration->user,
                    'abstrak' => $paper->abstrak,
                    'paper' => $paper,
                    'note' => $validatedData['note'],
                ], function ($message) use ($paper) {
                    $message->to($paper->abstrak->registration->user->email);
                    $message->subject('Submission Accepted');
                    $pdfController = app()->make(PDFController::class);
                    $response = $pdfController->print_loa(base64_encode($paper->abstrak->registration->id), 'loa-paper');
                    $tempFile = tempnam(sys_get_temp_dir(), 'loa_paper') . '.pdf';
                    file_put_contents($tempFile, $response->getContent());
                    $message->attach($tempFile, [
                        'as' => 'LOA_' . $paper->abstrak->registration->id . $paper->abstrak->registration->category->name . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
                    register_shutdown_function(function () use ($tempFile) {
                        @unlink($tempFile);
                    });
                });
            } catch (\Exception $e) {
            }
        } else if ($validatedData['status'] == Paper::REVISI_MAYOR || $validatedData['status'] == Paper::REVISI_MINOR) {
            try {
                Mail::send('emails.submission-revisi', [
                    'user' => $paper->abstrak->registration->user,
                    'abstrak' => $paper->abstrak,
                    'paper' => $paper,
                    'note' => $validatedData['note'],
                ], function ($message) use ($paper) {
                    $message->to($paper->abstrak->registration->user->email);
                    $message->subject('Submission Revision');
                });
            } catch (\Exception $e) {
            }
        }
        // }
        Toastr::success('Review paper berhasil disimpan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function published(Paper $paper)
    {
        $paper->update([
            'published_review' => Paper::PUBLISHED_REVIEW,
        ]);
        Toastr::success('Konfirmasi publikasi paper berhasil disimpan. Silahka tunggu validasi dari admin', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function publishedReview()
    {
        $data = [
            'title' => 'Validasi Publikasi',
            'subtitle' => "Tabel Konfirmasi Publikasi Paper",
            'active' => 'published',
            'papers' => Paper::with(['abstrak'])->where('published_review', Paper::PUBLISHED_REVIEW)->where('is_published', null)->get(),
        ];
        return view('pages.paper.published', $data);
    }

    public function publishedAcc(Paper $paper)
    {
        $paper->update([
            'is_published' => Paper::IS_PUBLISHED,
        ]);
        Toastr::success('Acc publikasi paper berhasil disimpan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function publishedPaper()
    {
        $data = [
            'title' => 'History Publikasi paper',
            'subtitle' => "Tabel istory Publikasi paper",
            'active' => 'published_history',
            'papers' => Paper::with(['abstrak'])->where('is_published', Paper::IS_PUBLISHED)->get(),
        ];
        return view('pages.paper.published', $data);
    }

}
