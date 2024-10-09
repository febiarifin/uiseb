<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Abstrak;
use App\Models\Paper;
use App\Models\Penulis;
use App\Models\RevisiAbstrak;
use App\Models\Setting;
use App\Models\User;
use App\Rules\WordCount;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
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
            'title' => ['required', new WordCount(20)],
            'type_paper' => ['required'],
            'keyword' => ['required'],
            'abstract' => ['required', new WordCount(250)],
            'file' => ['required', 'mimes:docx', 'max:5000'],
        ]);

        // return $validatedData;

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
        try {
            Mail::send('emails.submission-received', [
                'user' => $abstrak->registration->user,
                'abstrak' => $abstrak,
                'paper' => null,
            ], function ($message) use ($abstrak) {
                $message->to($abstrak->registration->user->email);
                $message->subject('Submission Received');
                $message->attach(public_path($abstrak->file));
            });
        } catch (\Exception $e) {
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
        $abstrak = Abstrak::with(['registration', 'registration.user'])->findOrFail($id);
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
            $validatedData['status'] = $request->status;
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
        $abstrak->update([
            'status' => $validatedData['status'],
            'acc_at' => $validatedData['status'] == Abstrak::ACCEPTED ? now() : null,
        ]);
        if ($request->status && Auth::user()->type == User::TYPE_REVIEWER || Auth::user()->type == User::TYPE_EDITOR || Auth::user()->type == User::TYPE_ADMIN || Auth::user()->type == User::TYPE_SUPER_ADMIN) {
            if ($validatedData['status'] == Abstrak::REJECTED) {
                AppHelper::create_abstrak($abstrak->registration);
            } else if ($validatedData['status'] == Abstrak::ACCEPTED) {
                AppHelper::create_paper($abstrak);
                try {
                    Mail::send('emails.submission-accepted', [
                        'user' => $abstrak->registration->user,
                        'abstrak' => $abstrak,
                        'paper' => null,
                        'note' => $request->note,
                    ], function ($message) use ($abstrak) {
                        $message->to($abstrak->registration->user->email);
                        $message->subject('Submission Accepted');
                        $pdfController = app()->make(PDFController::class);
                        $response = $pdfController->print_loa(base64_encode($abstrak->registration->id));
                        $tempFile = tempnam(sys_get_temp_dir(), 'loa_') . '.pdf';
                        file_put_contents($tempFile, $response->getContent());
                        $message->attach($tempFile, [
                            'as' => 'LOA_' . $abstrak->registration->id . $abstrak->registration->category->name . '.pdf',
                            'mime' => 'application/pdf',
                        ]);
                        register_shutdown_function(function () use ($tempFile) {
                            @unlink($tempFile);
                        });
                    });
                } catch (\Exception $e) {
                }
            } else if ($validatedData['status'] == Abstrak::REVISI_MAYOR || $validatedData['status'] == Abstrak::REVISI_MINOR) {
                try {
                    Mail::send('emails.submission-revisi', [
                        'user' => $abstrak->registration->user,
                        'abstrak' => $abstrak,
                        'paper' => null,
                        'note' => $request->note,
                    ], function ($message) use ($abstrak) {
                        $message->to($abstrak->registration->user->email);
                        $message->subject('Submission Revision');
                    });
                } catch (\Exception $e) {
                }
            }
        }
        Toastr::success('Review abstrak berhasil disimpan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function updateAuthor(Request $request, $id)
    {
        $abstrak = Abstrak::findOrFail($id);
        if (count($request->first_names) != count($abstrak->penulis)) {
            foreach ($abstrak->penulis as $author) {
                $author->delete();
            }
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
        }else{
            foreach ($abstrak->penulis as $i => $author) {
                $author->update([
                    'first_name' => $request->first_names[$i],
                    'middle_name' => $request->middle_names[$i],
                    'last_name' => $request->last_names[$i],
                    'email' => $request->emails[$i],
                    'affiliate' => $request->affiliates[$i],
                    'coresponding' => $request->corespondings[$i],
                    'degree' => $request->degrees[$i],
                    'address' => $request->address[$i],
                    'research_interest' => $request->research_interests[$i],
                ]);
            }
        }
        Toastr::success('Author berhasil diupdate', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }
}
