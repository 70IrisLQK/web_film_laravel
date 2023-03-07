<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listCountries  = Country::orderBy('id', 'DESC')->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.country.index', compact('listCountries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.country.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:categories|max:500',
            'slug' => 'required|unique:categories|max:500',
            'description' => 'required|max:500',
            'status' => 'required',
        ], [
            'title.unique' => 'Title already exist. Please try change title',
            'slug.unique' => 'Slug already exist. Please try change slug',
            'title.required' => 'Title is required',
            'slug.required' => 'Slug is required',
            'description.required' => 'Description is required',
            'status.required' => 'Status is required',
            'title' => 'Title max character 500. Please input few than.',
            'slug' => 'Title max character 500. Please input few than.'
        ]);

        $newCountry = new Country();
        $newCountry->id = Str::random(24);
        $newCountry->title = $data['title'];
        $newCountry->slug = $data['slug'];
        $newCountry->description = $data['description'];
        $newCountry->status = $data['status'];
        $newCountry->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newCountry->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        $newCountry->save();
        toastr()->success('Data has been saved successfully!', 'Congrats');
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
        $listCountryById = Country::find($id);
        return view('admin.country.form', compact('listCountryById'));
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
        $data = $request->validate([
            'title' => 'required|unique:countries|max:500',
            'slug' => 'required|unique:countries|max:500',
            'description' => 'required|max:500',
            'status' => 'required',
        ], [
            'title.unique' => 'Title already exist. Please try change title',
            'slug.unique' => 'Slug already exist. Please try change slug',
            'title.required' => 'Title is required',
            'slug.required' => 'Slug is required',
            'description.required' => 'Description is required',
            'status.required' => 'Status is required',
            'title' => 'Title max character 500. Please input few than.',
            'slug' => 'Title max character 500. Please input few than.'
        ]);

        $updateCountry = Country::find($id);
        $updateCountry->title = $data['title'];
        $updateCountry->slug = $data['slug'];
        $updateCountry->description = $data['description'];
        $updateCountry->status = $data['status'];
        $updateCountry->updated_at = Carbon::now('Asia/Ho_Chi_Minh');

        $updateCountry->save();
        toastr()->success('Data has been updated successfully!', 'Congrats');
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
        Country::find($id)->delete();
        toastr()->success('Data has been deleted successfully!', 'Congrats');
        return redirect()->back();
    }

    public function countryStatus(Request $request)
    {
        $data = $request->all();
        $getCountryById = Country::where('id', $data['countryId'])->first();
        $getCountryById->status = $data['countryStatus'];

        $getCountryById->save();
    }
}