<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'title' => 'Pengaturan',
            'subtitle' => 'Edit Pengaturan',
            'active' => 'setting',
            'setting' => Setting::first(),
        ];
        return view('pages.setting.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::first();
        $validatedData = $request->validate([
            // 'information' => ['required'],
            // 'template_video' => ['required'],
            'template_abstract' => [Rule::requiredIf(function() use($request){
                if (empty($request->template_abstract)) {
                    return false;
                }
                return true;
            }),'mimes:docx','max: 5000'],
            'template_full_paper' => [Rule::requiredIf(function() use($request){
                if (empty($request->template_full_paper)) {
                    return false;
                }
                return true;
            }),'mimes:docx','max: 5000'],
            'confirmation_letter' => [Rule::requiredIf(function() use($request){
                if (empty($request->confirmation_letter)) {
                    return false;
                }
                return true;
            }),'mimes:docx','max: 5000'],
            'copyright_letter' => [Rule::requiredIf(function() use($request){
                if (empty($request->copyright_letter)) {
                    return false;
                }
                return true;
            }),'mimes:docx','max: 5000'],
            'self_declare_letter' => [Rule::requiredIf(function() use($request){
                if (empty($request->self_declare_letter)) {
                    return false;
                }
                return true;
            }),'mimes:docx','max: 5000'],
            'flayer' => [Rule::requiredIf(function() use($request){
                if (empty($request->flayer)) {
                    return false;
                }
                return true;
            }),'mimes:pdf','max: 5000'],
        ]);
        $validatedData['information'] = $request->information;
        $validatedData['template_video'] = $request->template_video;
        if ($request->template_abstract) {
            AppHelper::delete_file($setting->template_abstract);
            $validatedData['template_abstract'] = AppHelper::upload_file($request->template_abstract, 'files');
        };
        if ($request->template_full_paper) {
            AppHelper::delete_file($setting->template_full_paper);
            $validatedData['template_full_paper'] = AppHelper::upload_file($request->template_full_paper, 'files');
        };
        if ($request->confirmation_letter) {
            AppHelper::delete_file($setting->confirmation_letter);
            $validatedData['confirmation_letter'] = AppHelper::upload_file($request->confirmation_letter, 'files');
        };
        if ($request->copyright_letter) {
            AppHelper::delete_file($setting->copyright_letter);
            $validatedData['copyright_letter'] = AppHelper::upload_file($request->copyright_letter, 'files');
        };
        if ($request->self_declare_letter) {
            AppHelper::delete_file($setting->self_declare_letter);
            $validatedData['self_declare_letter'] = AppHelper::upload_file($request->self_declare_letter, 'files');
        };
        if ($request->flayer) {
            AppHelper::delete_file($setting->flayer);
            $validatedData['flayer'] = AppHelper::upload_file($request->flayer, 'files');
        };
        $setting->update($validatedData);
        Toastr::success('Setting berhasil disimpan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
