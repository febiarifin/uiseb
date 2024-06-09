<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Registration;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;

class RegisterController extends Controller
{

    public function index()
    {
        $data = [
            'title' => config('app.name'),
            'categories' => Category::all(),
        ];
        return view('pages.public.register', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required','email:dns','unique:users'],
            'phone_number' => ['required'],
            'institution' => ['required'],
            'position' => ['required'],
            'subject_background' => ['required'],
            'password' => ['required'],
            'confirm_password' => ['required'],
            'category_id' => ['required'],
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'type' => User::TYPE_PESERTA,
        ]);

        $token = Str::random(64);
        UserVerify::create([
              'user_id' => $user->id,
              'token' => $token
        ]);
        $validatedData['user_id'] = $user->id;
        $category = Category::find($validatedData['category_id']);
        $validatedData['status'] = $category->is_paper ? Registration::REVIEW : Registration::ACC;
        Registration::create($validatedData);

        // try {
            Mail::send('emails.verification', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Registration Verification Email');
            });
        // } catch (\Exception $e) {
        // }

        return redirect()->route('login.index')->with('success', 'Registration is successful, we have sent a verification email to <b>'. $validatedData['email']).'</b>';
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        $message = 'Sorry your email cannot be identified.';

        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }

      return redirect()->route('login.index')->with('success', $message);
    }

}
