@extends('layouts.admin_layout')
@section('content')
    <section class="wrapper">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    @if (isset($listCategoryById))
                        Update Category
                    @else
                        Create Category
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
                        @if (isset($listCategoryById))
                            <form method="POST" action="{{ route('category.update', [$listCategoryById->id]) }}">
                                @method('PUT')
                            @else
                                <form method="POST" action="{{ route('category.store') }}">
                        @endif

                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPassword1">Title</label>
                            <input type="text" class="form-control" id="slug" placeholder="Enter Title"
                                onkeyup="ChangeToSlug()" name="title"
                                value="{{ isset($listCategoryById) ? $listCategoryById->title : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Slug</label>
                            <input type="text" class="form-control" placeholder="Slug" id="convert_slug" name="slug"
                                value="{{ isset($listCategoryById) ? $listCategoryById->slug : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description</label>
                            <input type="text" class="form-control" placeholder="Description" name="description"
                                value="{{ isset($listCategoryById) ? $listCategoryById->description : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Status</label>
                            {!! Form::select(
                                'status',
                                ['0' => 'inactive', '1' => 'active'],
                                isset($listCategoryById) ? $listCategoryById->status : '',
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
