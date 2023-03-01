<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
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
        $listCategories  = Category::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.category.index', compact('listCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $newCategory = new Category();
        $newCategory->title = $data['title'];
        $newCategory->slug = $data['slug'];
        $newCategory->description = $data['description'];
        $newCategory->status = $data['status'];
        $newCategory->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newCategory->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        $newCategory->save();
        return redirect()->back();
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
        $listCategoryById = Category::find($id);
        return view('admin.category.form', compact('listCategoryById'));
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
        $data = $request->all();
        $updateCategory = Category::find($id);
        $updateCategory->title = $data['title'];
        $updateCategory->slug = $data['slug'];
        $updateCategory->description = $data['description'];
        $updateCategory->status = $data['status'];
        $updateCategory->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        $updateCategory->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->back();
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function resorting(Request $request)
    {
        $data = $request->all();
        foreach ($data['arrayId'] as $key => $value) {
            $category = Category::find($value);
            $category->position = $key;
            $category->save();
        }
    }
}