<?php

namespace App\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Manajemen User',
            'subtitle' => 'Tabel Data User',
            'active' => 'user',
            'users' => User::with(['registrations'])->orderBy('created_at','desc')->whereIn('type', [User::TYPE_EDITOR, User::TYPE_REVIEWER, User::TYPE_PESERTA, User::TYPE_COMMITTEE])->get(),
        ];
        return view('pages.user.index', $data);
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
            'email' => ['required','email:dns'],
            'type' => ['required'],
            'scopus' => ['required'],
            'institution' => ['required'],
        ]);
        $validatedData['password'] = Hash::make('UISEB123');
        if ($validatedData['type'] == User::TYPE_PESERTA) {
            $validatedData['is_email_verified'] = User::IS_EMAIL_VERIFIED;
        }
        User::create($validatedData);
        Toastr::success('User berhasil ditambahkan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data = [
            'title' => 'Edit User',
            'subtitle' => null,
            'active' => 'user',
            'user' => $user,
        ];
        return view('pages.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required','email:dns'],
            'type' => ['required'],
            'scopus' => ['required'],
            'institution' => ['required'],
        ]);
        $user->update($validatedData);
        Toastr::success('User berhasil diupdate', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        Toastr::success('User berhasil ditambahkan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function profile()
    {
        $country_codes = Http::get('https://gist.githubusercontent.com/anubhavshrimal/75f6183458db8c453306f93521e93d37/raw/f77e7598a8503f1f70528ae1cbf9f66755698a16/CountryCodes.json')->json();
        $data = [
            'title' => 'Profile User',
            'subtitle' => null,
            'active' => 'dashboard',
            'user' => Auth::user(),
            'country_codes' => $country_codes,
        ];
        return view('pages.user.profile', $data);
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'phone_number' => ['required'],
            'institution' => ['required'],
            'position' => ['required'],
            'subject_background' => ['required'],
            'scopus' => ['required'],
        ]);
        Auth::user()->update($validatedData);
        Toastr::success('Profil berhasil disimpan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function updatePassword(Request $request,User $user)
    {
        $user = Auth::user();
        $request->validate([
           'old_password' => ['required'],
           'password' => ['required'],
        ]);
        if (Auth::attempt(["email" => $user->email, "password" => $request->old_password])){
            $validatedData['password'] = Hash::make($request->password);
            $user->update($validatedData);
            Toastr::success('Password berhasil diupdate', 'Success', ["positionClass" => "toast-top-right"]);
        }else{
            Toastr::error('Password lama salah', 'Error', ["positionClass" => "toast-top-right"]);
        }
        return back();
    }
}
