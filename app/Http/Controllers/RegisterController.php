<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Mail\NotificationMail;
use App\Models\Category;
use App\Models\Page;
use App\Models\Registration;
use App\Models\Revision;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserVerify;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function index()
    {
        $country_codes = Http::get('https://gist.githubusercontent.com/anubhavshrimal/75f6183458db8c453306f93521e93d37/raw/f77e7598a8503f1f70528ae1cbf9f66755698a16/CountryCodes.json')->json();
        $data = [
            'title' => config('app.name'),
            'categories' => Category::all(),
            'country_codes' => $country_codes,
        ];
        return view('pages.public.register', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'phone_number' => ['required'],
            'country_code' => ['required'],
            'institution' => ['required'],
            'position' => ['required'],
            'subject_background' => ['required'],
            'password' => ['required'],
            'confirm_password' => ['required'],
            // 'category_id' => ['required'],
            'degree' => ['required'],
            'research_interest' => ['required'],
        ]);

        list($code, $name) = explode(',', $validatedData['country_code']);
        $code = str_replace('+', '', $code);
        $validatedData['phone_number'] = trim($code) . $validatedData['phone_number'];
        $validatedData['name'] = $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name;
        $validatedData['first_name'] = $request->first_name;
        $validatedData['middle_name'] = $request->middle_name;
        $validatedData['last_name'] = $request->last_name;

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['type'] = User::TYPE_PESERTA;
        $user = User::create($validatedData);

        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        $validatedData['user_id'] = $user->id;
        // $registration = Registration::create($validatedData);
        // AppHelper::create_abstrak($registration);

        try {
            Mail::send('emails.verification', [
                'token' => $token,
                'user' => $user,
            ], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Registration Verification Email');
            });
        } catch (\Exception $e) {
        }

        return redirect()->route('login.index')->with('success', 'Registration is successful, we have sent a verification email to <b>' . $validatedData['email']) . '</b>';
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Sorry your email cannot be identified.';
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = User::IS_EMAIL_VERIFIED;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

        return redirect()->route('login.index')->with('success', $message);
    }

    public function uploadPayment($id)
    {
        $registration = Registration::findOrFail($id);
        if (Auth::user()->id != $registration->user_id) {
            return back();
        }
        $data = [
            'title' => 'Upload Bukti Pembayaran',
            'subtitle' => null,
            'active' => 'registration',
            'registration' => $registration,
            'setting' => Setting::first(),
        ];
        return view('pages.registration.payment', $data);
    }

    public function uploadPaymentStore(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        if (Auth::user()->id != $registration->user_id) {
            return back();
        }
        $validatedData = $request->validate([
            'payment_image' => ['required', 'mimes:png,jpg,jpeg', 'max:500'],
        ]);
        AppHelper::delete_file($registration->payment_image);
        $validatedData['payment_image'] = AppHelper::upload_file($request->payment_image, 'images');
        $validatedData['is_valid'] = null;
        $registration->update($validatedData);
        try {
            Mail::send('emails.payment-received', [
                'user' => $registration->user,
                'registration' => $registration,
            ], function ($message) use ($registration) {
                $message->to($registration->user->email);
                $message->subject('Payment Received');
                $message->attach(public_path($registration->payment_image));
            });
        } catch (\Exception $e) {
        }
        return redirect()->route('dashboard');
    }

    public function uploadPaper($id)
    {
        $registration = Registration::findOrFail($id);
        if (Auth::user()->id != $registration->user_id) {
            return back();
        }
        $data = [
            'title' => 'Upload Paper',
            'subtitle' => null,
            'active' => 'registration',
            'registration' => $registration,
        ];
        return view('pages.registration.paper', $data);
    }

    public function uploadPaperStore(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        if (Auth::user()->id != $registration->user_id) {
            return back();
        }
        $validatedData = $request->validate([
            'paper' => ['required', 'mimes:pdf', 'max:500'],
        ]);
        $validatedData['paper'] = AppHelper::upload_file($request->paper, 'papers');
        $validatedData['status'] = Registration::REVIEW;
        $registration->update($validatedData);
        return redirect()->route('registration.user');
    }

    public function registrationUser()
    {
        $user = User::findOrFail(Auth::user()->id);
        $registrations = $user->registrations()->with(['category'])->orderBy('created_at', 'desc')->get();
        $data = [
            'title' => 'Registration',
            'subtitle' => null,
            'active' => 'registration',
            'registrations' => $registrations,
        ];
        return view('pages.registration.user', $data);
    }

    public function registrationDetail($id)
    {
        $registration = Registration::where('id', $id)->with(['category', 'revisions'])->first();
        if (Auth::user()->type == User::TYPE_PESERTA) {
            if (Auth::user()->id != $registration->user_id) {
                return back();
            }
        }
        $data = [
            'title' => 'Detail Registration',
            'subtitle' => null,
            'active' => 'dashboard',
            'registration' => $registration,
            'type' => 'detail',
        ];
        return view('pages.registration.detail', $data);
    }

    public function registrationValidation()
    {
        $registrations = Registration::with(['category', 'user'])
            ->where('is_valid', null)
            ->where('payment_image', '!=', null)
            ->get();
        $data = [
            'title' => 'Validasi Pendaftaran',
            'subtitle' => 'Tabel Pendaftaran Peserta',
            'active' => 'validation',
            'registrations' => $registrations,
        ];
        return view('pages.registration.validation', $data);
    }

    public function registrationValidate($id)
    {
        $registration = Registration::where('id', $id)->with(['category'])->first();
        $data = [
            'title' => 'Validasi Pendaftaran Peserta',
            'subtitle' => null,
            'active' => 'validation',
            'registration' => $registration,
            'type' => 'validate',
        ];
        return view('pages.registration.detail', $data);
    }

    public function registrationAcc($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update([
            'is_valid' => Registration::IS_VALID,
            'validated_at' => now(),
        ]);
        Toastr::success('Pendaftaran berhasil divalidasi', 'Success', ["positionClass" => "toast-top-right"]);
        try {
            Mail::send('emails.payment-received', [
                'user' => $registration->user,
                'registration' => $registration,
            ], function ($message) use ($registration) {
                $message->to($registration->user->email);
                $message->subject('Payment Accepted');
                $pdfController = app()->make(PDFController::class);
                $response = $pdfController->print_invoice(base64_encode($registration->id));
                $tempFile = tempnam(sys_get_temp_dir(), 'invoice_') . '.pdf';
                file_put_contents($tempFile, $response->getContent());
                $message->attach($tempFile, [
                    'as' => 'INVOICE_' . $registration->id . $registration->category->name . '.pdf',
                    'mime' => 'application/pdf',
                ]);
                register_shutdown_function(function () use ($tempFile) {
                    @unlink($tempFile);
                });
            });
        } catch (\Exception $e) {
        }
        return redirect()->route('registration.validation');
    }

    public function registrationRevisi(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update([
            'note' => $request->note,
            'is_valid' => Registration::NOT_VALID,
        ]);
        Toastr::success('Pendaftaran berhasil direvisi', 'Success', ["positionClass" => "toast-top-right"]);
        try {
            Mail::to($registration->user->email)->send(new NotificationMail([
                'subject' => 'Registration Validation',
                'message' => 'Your registration has been REVISI. Resubmit
                        immediately!. <br>Note: ' . $request->note,
            ]));
        } catch (\Exception $e) {
        }
        return redirect()->route('registration.validation');
    }

    public function registrationReviews()
    {
        $registrations = Registration::with(['category', 'user'])->where('status', Registration::REVIEW)->get();
        $data = [
            'title' => 'Review Pendaftaran',
            'subtitle' => 'Tabel Pendaftaran Peserta',
            'active' => 'review',
            'registrations' => $registrations,
        ];
        return view('pages.registration.review', $data);
    }

    public function registrationReview($id)
    {
        $registration = Registration::where('id', $id)->with(['category', 'revisions'])->first();
        $data = [
            'title' => 'Review Paper',
            'subtitle' => null,
            'active' => 'review',
            'registration' => $registration,
            'type' => 'review',
        ];
        return view('pages.registration.detail', $data);
    }

    public function registrationPaperRevisi(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update([
            'status' => Registration::REVISI,
        ]);
        $revision = new Revision;
        $revision->note = $request->note;
        $revision->attachment = $registration->paper;
        $revision->user_id = Auth::user()->id;
        $registration->revisions()->save($revision);
        Toastr::success('Paper berhasil direvisi', 'Success', ["positionClass" => "toast-top-right"]);
        try {
            Mail::to($registration->user->email)->send(new NotificationMail([
                'subject' => 'Paper Review',
                'message' => 'Your paper has been REVISI. Resubmit
                        immediately!. <br>Note: ' . $request->note,
            ]));
        } catch (\Exception $e) {
        }
        return redirect()->route('registration.reviews');
    }

    public function registrationPaperAcc($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->update([
            'status' => Registration::ACC,
            'acc_at' => now(),
        ]);
        Toastr::success('Paper berhasil di ACC', 'Success', ["positionClass" => "toast-top-right"]);
        try {
            Mail::to($registration->user->email)->send(new NotificationMail([
                'subject' => 'Paper Review',
                'message' => 'Congratulations, your paper has been ACC.',
            ]));
        } catch (\Exception $e) {
        }
        return redirect()->route('registration.reviews');
    }

    public function registrationHistory()
    {
        $registrations = Registration::orderBy('created_at', 'desc')->with([
            'category',
            'user',
            'abstraks' => function ($query) {
                $query->with([
                    'papers' => function ($query) {
                        $query->with('videos');
                    }
                ]);
            }
        ])->get();
        $data = [
            'title' => 'Riwayat Pendaftaran Peserta',
            'subtitle' => 'Tabel Pendaftaran Peserta',
            'active' => 'registration',
            'registrations' => $registrations,
        ];
        return view('pages.registration.history', $data);
    }

    public function registrationList()
    {
        $user = User::with(['registrations'])->findOrFail(Auth::user()->id);
        if (count($user->registrations) != 0) {
            return back();
        }
        $page = Page::with(['timelines', 'contacts', 'speakers', 'articles'])->where('status', Page::ENABLE)->whereYear('created_at', now())->first();
        if (!$page) {
            $page = Page::with(['timelines', 'contacts', 'speakers', 'articles'])->first();
        }
        $data = [
            'title' => 'Choose Category Registration',
            'subtitle' => null,
            'active' => 'dashboard',
            'categories' => $page->categories()->where('is_active', Category::IS_ACTIVE)->paginate(4),
        ];
        return view('pages.registration.list', $data);
    }

    public function registrationCreate($id)
    {
        $user = User::with(['registrations'])->findOrFail(Auth::user()->id);
        if (count($user->registrations) != 0) {
            return back();
        }
        $category = Category::findOrFail($id);
        $data = [
            'title' => 'Create New Registration',
            'subtitle' => null,
            'active' => 'registration',
            'category' => $category,
            'user' => Auth::user(),
        ];
        return view('pages.registration.create', $data);
    }

    public function registrationStore(Request $request)
    {
        $registration = Registration::create([
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id,
        ]);
        AppHelper::create_abstrak($registration);
        Toastr::success('Registration was successful', 'Success', ["positionClass" => "toast-top-right"]);
        try {
            Mail::send('emails.confirmation-registration', [
                'user' => $registration->user,
                'registration' => $registration,
            ], function ($message) use ($registration) {
                $message->to($registration->user->email);
                $message->subject('Registration Confirmation');
                $pdfController = app()->make(PDFController::class);
                $response = $pdfController->print_invoice(base64_encode($registration->id));
                $tempFile = tempnam(sys_get_temp_dir(), 'invoice_') . '.pdf';
                file_put_contents($tempFile, $response->getContent());
                $message->attach($tempFile, [
                    'as' => 'INVOICE_' . $registration->id . $registration->category->name . '.pdf',
                    'mime' => 'application/pdf',
                ]);
                register_shutdown_function(function () use ($tempFile) {
                    @unlink($tempFile);
                });
            });
        } catch (\Exception $e) {
        }
        return redirect()->route('dashboard');
    }

    public function printInvoice(Registration $registration)
    {
        $data = [
            'title' => 'Invoice Registration',
            'subtitle' => null,
            'active' => 'dashboard',
            'registration' => $registration,
        ];
        return view('pages.registration.invoice', $data);
    }

}
