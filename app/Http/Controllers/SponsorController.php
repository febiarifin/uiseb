<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Sponsor;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SponsorController extends Controller
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
        $validatedData = $request->validate([
            'image' => [Rule::requiredIf(function () {
                if (empty($this->request->image)) {
                    return false;
                }
                return true;
            }), 'mimes:jpg,png,jpeg', 'max:1000'],
            'name' => ['required'],
            'page_id' => ['required']
        ]);
        if ($request->image) {
            $validatedData['image'] = AppHelper::upload_file($request->image,'images');
        }
        Sponsor::create($validatedData);
        Toastr::success('Sponsor berhasil ditambahkan', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        $sponsor->delete();
        Toastr::success('Sponsor berhasil dihapus', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }
}
