@extends('layouts.admin_layout')
@section('content')
    <section class="wrapper">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    @if (isset($listMovieById))
                        Update Movie
                    @else
                        Create Movie
                    @endif
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                        @if (isset($listMovieById))
                            <form method="POST" action="{{ route('movie.update', [$listMovieById->id]) }}"
                                enctype="multipart/form-data">
                                @method('PUT')
                            @else
                                <form method="POST" action="{{ route('movie.store') }}" enctype="multipart/form-data">
                        @endif

                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Title</label>
                            <input type="text" class="form-control" id="slug" placeholder="Enter Title"
                                onkeyup="ChangeToSlug()" name="title"
                                value="{{ isset($listMovieById) ? $listMovieById->title : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Slug</label>
                            <input type="text" class="form-control" placeholder="Slug" id="convert_slug" name="slug"
                                value="{{ isset($listMovieById) ? $listMovieById->slug : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Original Title</label>
                            <input type="text" class="form-control" name="original_title"
                                value="{{ isset($listMovieById) ? $listMovieById->original_title : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Trailer</label>
                            <input type="text" class="form-control" name="trailer"
                                value="{{ isset($listMovieById) ? $listMovieById->trailer : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Belong Movie</label>
                            <input type="text" class="form-control" name="belong_movie"
                                value="{{ isset($listMovieById) ? $listMovieById->belong_movie : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Duration</label>
                            <input type="text" class="form-control" name="duration"
                                value="{{ isset($listMovieById) ? $listMovieById->duration : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tag</label>
                            <textarea type="text" class="form-control" name="tags"
                                value="{{ isset($listMovieById) ? $listMovieById->tags : '' }}"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <textarea type="text" class="form-control" name="description"
                                value="{{ isset($listMovieById) ? $listMovieById->description : '' }}"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <input type="file" name="image">
                        </div>
                        @if (isset($listMovieById))
                            <img width="15%" src="{{ asset('uploads/movies/' . $listMovieById->image) }}" />
                        @endif

                        <div class="form-group">
                            <label for="exampleInputPassword1">Status</label>
                            <select class="form-control" aria-label="Default select example" name="status">
                                @if (isset($listMovieById))
                                    @if ($listMovieById->status == 0)
                                        <option value="0" selected>Inactive</option>
                                        <option value="1">Active</option>
                                    @else
                                        <option value="0">Inactive</option>
                                        <option value="1" selected>Active</option>
                                    @endif
                                @else
                                    <option value="0" selected>Inactive</option>
                                    <option value="1">Active</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Resolution</label>
                            <select class="form-control" aria-label="Default select example" name="resolution">
                                @if (isset($listMovieById))
                                    @if ($listMovieById->resolution == 0)
                                        <option value="0" selected>FULL HD</option>
                                        <option value="1">HD</option>
                                    @else
                                        <option value="0">FULL HD</option>
                                        <option value="1" selected>HD</option>
                                    @endif
                                @else
                                    <option value="0" selected>FULL HD</option>
                                    <option value="1">HD</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">SubTitle</label>
                            <select class="form-control" aria-label="Default select example" name="subtitle">
                                @if (isset($listMovieById))
                                    @if ($listMovieById->status == 0)
                                        <option value="0" selected>Thuyết Minh</option>
                                        <option value="1">ViệtSub</option>
                                    @else
                                        <option value="0">Thuyết Minh</option>
                                        <option value="1" selected>ViệtSub</option>
                                    @endif
                                @else
                                    <option value="0" selected>Thuyết Minh</option>
                                    <option value="1">ViệtSub</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Movie Hot</label>
                            <select class="form-control" aria-label="Default select example" name="movie_hot">
                                @if (isset($listMovieById))
                                    @if ($listMovieById->status == 0)
                                        <option value="0" selected>Inactive</option>
                                        <option value="1">Active</option>
                                    @else
                                        <option value="0">Inactive</option>
                                        <option value="1" selected>Active</option>
                                    @endif
                                @else
                                    <option value="0" selected>Inactive</option>
                                    <option value="1">Active</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Category</label>
                            <select class="form-control" aria-label="Default select example" name="category_id">
                                @if (isset($listMovieById))
                                    <option selected value="{{ $listMovieById->category->id }}">
                                        {{ $listMovieById->category->title }}</option>
                                @else
                                    <option selected>Choose Category</option>
                                @endif
                                @foreach ($listCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Country</label>
                            <select class="form-control" aria-label="Default select example" name="country_id"
                                value="">
                                @if (isset($listMovieById))
                                    <option selected value="{{ $listMovieById->country->id }}">
                                        {{ $listMovieById->country->title }}</option>
                                @else
                                    <option selected>Choose Country</option>
                                @endif
                                @foreach ($listCountries as $country)
                                    <option value="{{ $country->id }}">{{ $country->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="exampleInputPassword1">Genre</label>
                        <div class="form-check form-check-inline">
                            @foreach ($listGenres as $genre)
                                @if (isset($listMovieById))
                                    {!! Form::checkbox(
                                        'genre[]',
                                        $genre->id,
                                        isset($listMovieGenre) && $listMovieGenre->contains($genre->id) ? true : false,
                                    ) !!}
                                    <label class="badge badge-light" for="inlineCheckbox1">{{ $genre->title }}</label>
                                @else
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                        value="{{ $genre->id }}" name="genre[]">
                                    <label class="badge badge-light" for="inlineCheckbox1">{{ $genre->title }}</label>
                                @endif
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-info">Submit</button>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    </section>
@endsection
