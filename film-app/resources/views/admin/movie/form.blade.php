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
                            <input type="text" class="form-control" name="origin_name"
                                value="{{ isset($listMovieById) ? $listMovieById->origin_title : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Quality</label>
                            {!! Form::select(
                                'quality',
                                ['0' => 'CAM', '1' => 'SD', '2' => 'HD', '3' => 'Full HD'],
                                isset($listMovieById) ? $listMovieById->quality : '',
                                [
                                    'class' => 'form-control',
                                ],
                            ) !!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Language</label>
                            {!! Form::select(
                                'lang',
                                ['0' => 'Vietsub', '1' => 'Thuyết minh', '2' => 'HD', '3' => 'Full HD'],
                                isset($listMovieById) ? $listMovieById->lang : '',
                                [
                                    'class' => 'form-control',
                                ],
                            ) !!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Time</label>
                            <input type="text" class="form-control" name="time"
                                value="{{ isset($listMovieById) ? $listMovieById->time : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Total Episode</label>
                            <input type="text" class="form-control" name="episode_total"
                                value="{{ isset($listMovieById) ? $listMovieById->episode_total : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Genre</label>
                            <div class="form-check form-check-inline">
                                @foreach ($listGenres as $genre)
                                    {!! Form::checkbox(
                                        'genre[]',
                                        $genre->id,
                                        isset($listMovieGenre) && $listMovieGenre->contains($genre->id) ? true : false,
                                    ) !!}
                                    <label class="badge badge-light" for="inlineCheckbox1">{{ $genre->title }}</label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Category</label>
                            {!! Form::select('category_id', $listCategories, isset($listMovieById) ? $listMovieById->category_id : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Country</label>
                            {!! Form::select('country_id', $listCountries, isset($listMovieById) ? $listMovieById->country_id : '', [
                                'class' => 'form-control',
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <textarea type="text" class="form-control" name="description"
                                value="{{ isset($listMovieById) ? $listMovieById->description : '' }}"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Tag</label>
                            <textarea type="text" class="form-control" name="tags"
                                value="{{ isset($listMovieById) ? $listMovieById->tags : '' }}"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Trailer</label>
                            <input type="text" class="form-control" name="trailer_url"
                                value="{{ isset($listMovieById) ? $listMovieById->trailer_url : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Type</label>
                            {!! Form::select(
                                'type',
                                ['0' => 'single', '1' => 'series', '2' => 'cartoon'],
                                isset($listMovieById) ? $listMovieById->tpye : '',
                                [
                                    'class' => 'form-control',
                                ],
                            ) !!}
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <input type="file" name="image">
                            @if (isset($listMovieById))
                                <img width="20%" src="{{ asset('uploads/movies/' . $listMovieById->image) }}" />
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="exampleInputPassword1">Most view</label>
                            {!! Form::select(
                                'most_view',
                                ['0' => 'Ngày', '1' => 'Tuần', '2' => 'Tháng'],
                                isset($listMovieById) ? $listMovieById->most_view : '',
                                ['class' => 'form-control'],
                            ) !!}
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Hot Movie</label>
                            {!! Form::select(
                                'movie_hot',
                                ['0' => 'inactive', '1' => 'active'],
                                isset($listMovieById) ? $listMovieById->movie_hot : '',
                                ['class' => 'form-control'],
                            ) !!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Status Movie</label>
                            {!! Form::select(
                                'status_movie',
                                ['0' => 'ongoing', '1' => 'completed'],
                                isset($listGenreById) ? $listGenreById->status : '',
                                [
                                    'class' => 'form-control',
                                ],
                            ) !!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Status</label>
                            {!! Form::select(
                                'status',
                                ['0' => 'inactive', '1' => 'active'],
                                isset($listGenreById) ? $listGenreById->status : '',
                                [
                                    'class' => 'form-control',
                                ],
                            ) !!}
                        </div>
                        <button type="submit" class="btn btn-info">Submit</button>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    </section>
@endsection
