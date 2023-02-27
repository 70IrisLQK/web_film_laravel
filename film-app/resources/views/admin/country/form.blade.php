@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Country Management</div>

                    <div class="card-body">
                        @if (!isset($listCountryById))
                            {!! Form::open(['method' => 'POST', 'route' => 'country.store']) !!}
                        @else
                            {!! Form::open(['method' => 'PUT', 'route' => ['country.update', $listCountryById->id]]) !!}
                        @endif
                        <div class="form-group">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($listCountryById) ? $listCountryById->title : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input title',
                                'id' => 'slug',
                                'onkeyup' => 'ChangeToSlug()',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($listCountryById) ? $listCountryById->slug : null, [
                                'class' => 'form-control',
                                'placeholder' => 'Input slug',
                                'id' => 'convert_slug',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($listCountryById) ? $listCountryById->description : null, [
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
                                isset($listCountryById) ? $listCountryById->status : null,
                                [],
                            ) !!}
                        </div>
                        @if (!isset($listCountryById))
                            {!! Form::submit('Save Country', ['class' => 'btn btn-success']) !!}
                        @else
                            {!! Form::submit('Update Country', ['class' => 'btn btn-success']) !!}
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
                <tbody>
                    @foreach ($listCountries as $key => $country)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $country->title }}</td>
                            <td>{{ $country->slug }}</td>
                            <td>{{ $country->description }}</td>
                            <td>
                                @if ($country->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td>
                                {!! Form::open([
                                    'method' => 'DELETE',
                                    'route' => ['country.destroy', $country->id],
                                    'onsubmit' => 'return confirm("Do you want to delete?")',
                                ]) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}

                                <a href="{{ route('country.edit', $country->id) }}" class="btn btn-warning">
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
