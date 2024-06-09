<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Manajemen Kategori',
            'subtitle' => 'Tabel Kategori Seminar',
            'active' => 'category',
            'categories' => Category::all(),
        ];
        return view('pages.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Buat Kategori',
            'subtitle' => null,
            'active' => 'category',
        ];
        return view('pages.category.create', $data);
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
            'description' => ['required'],
            'amount' => ['required'],
        ]);
        $validatedData['is_paper'] = $request->is_paper ? Category::IS_PAPER : 0;
        Category::create($validatedData);
        Toastr::success('Kategori berhasil ditambahkan', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data = [
            'title' => 'Edit Kategori',
            'subtitle' => null,
            'active' => 'category',
            'category' => $category,
        ];
        return view('pages.category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'amount' => ['required'],
        ]);
        $validatedData['is_paper'] = $request->is_paper ? Category::IS_PAPER : 0;
        $category->update($validatedData);
        Toastr::success('Kategori berhasil diupdate', 'Success', ["positionClass" => "toast-top-right"]);
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Toastr::success('Kategori berhasil dihapus', 'Success', ["positionClass" => "toast-top-right"]);
        return back();
    }
}
