@extends('layouts.admin_layout')
@section('content')
    <section class="wrapper">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    @if (isset($listGenreById))
                        Update Genre
                    @else
                        Create Genre
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
                        @if (isset($listGenreById))
                            <form method="POST" action="{{ route('genre.update', [$listGenreById->id]) }}">
                                @method('PUT')
                            @else
                                <form method="POST" action="{{ route('genre.store') }}">
                        @endif

                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Title</label>
                            <input type="text" class="form-control" id="slug" placeholder="Enter Title"
                                onkeyup="ChangeToSlug()" name="title"
                                value="{{ isset($listGenreById) ? $listGenreById->title : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Slug</label>
                            <input type="text" class="form-control" placeholder="Slug" id="convert_slug" name="slug"
                                value="{{ isset($listGenreById) ? $listGenreById->slug : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <input type="text" class="form-control" placeholder="Description" name="description"
                                value="{{ isset($listGenreById) ? $listGenreById->description : '' }}">
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
