@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Category Management</div>

                    <div class="card-body">
                        @if (!isset($listCategoryById))
                            {!! Form::open(['method' => 'POST', 'route' => 'category.store']) !!}
                        @else
                            {!! Form::open(['method' => 'PUT', 'route' => ['category.update', $listCategoryById->id]]) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($listCategoryById) ? $listCategoryById->title : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input title',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($listCategoryById) ? $listCategoryById->slug : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input slug',
                                'id' => 'convert_slug',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($listCategoryById) ? $listCategoryById->description : null, [
                                'style' => 'resize:none',
                                'class' => 'form-control',
                                'placeholder' => 'Input description',
                                'id' => 'description',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('status', 'Status', []) !!}
                            {!! Form::select(
                                'status',
                                ['1' => 'Active', '0' => 'Inactive'],
                                isset($listCategoryById) ? $listCategoryById->status : null,
                                [],
                            ) !!}
                        </div>
                        @if (!isset($listCategoryById))
                            {!! Form::submit('Save Category', ['class' => 'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Update Category', ['class' => 'btn btn-success']) !!}
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Title</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Manage</th>
                    </tr>
                </thead>
                <tbody class="order-position">
                    @foreach ($listCategories as $key => $category)
                        <tr id={{ $category->id }}>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $category->title }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                @if ($category->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td>
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['category.destroy', $category->id],
                                    'onsubmit' => 'return confirm("Do you want to delete?")',
                                ]) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}

                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
