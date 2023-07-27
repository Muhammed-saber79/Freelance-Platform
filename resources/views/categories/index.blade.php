@extends('layouts.dashboard')

@section('page-title')
This is <span class="text-success">Categories</span> page.
@endsection

@section('breadcrumb')
Categories List
@endsection

@section('content')
<div class="container">
    <x-flash-message />

    <div class="row my-3">
        <a href="{{ route('categories.create') }}" class="mx-1">
            <button class="btn btn-outline-primary">Add New Category</button>
        </a>
        <a href="{{ route('index') }}" class="mx-1">
            <button class="btn btn-outline-info">Back To Users</button>
        </a>
    </div>

    <div class="row my-3">
        <div class="table-responsive">
        <table class="table table-striped
        table-hover	
        table-borderless
        table-primary
        align-middle">
            <thead class="table-light">
                <caption>Table Name</caption>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Parent</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($data as $row)
                <tr class="table-primary" >
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->parent }}</td>
                    <td class="d-flex flex-row justify-content-center">
                        <a href="{{ route('categories.show', $row->id) }}" class="mx-1"> 
                            <button class="btn btn-outline-info">Details</button>
                        </a>
                        <a href="{{ route('categories.edit', $row->id) }}" class="mx-1"> 
                            <button class="btn btn-outline-success">Edit</button>
                        </a>
                
                        <form action="{{ route('categories.destroy', $row->id) }}" method="POST" class="mx-1">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $data->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
    </div>
</div>    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@endsection