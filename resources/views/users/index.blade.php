@extends('layouts.dashboard')

@section('page-title')
Users List
@endsection

@section('breadcrumb')
Users List
@endsection

@section('content')
<div class="container">
    <div class="row my-5">
        <h1 class="text-center">This is <span class="text-success">index</span> page.</h1>
    </div>

    <x-flash-message />

    <div class="row my-3">
        <a href="{{ route('users.add') }}" class="mx-1">
            <button class="btn btn-outline-primary">Add New User</button>
        </a>
        <a href="{{ route('categories.index') }}" class="mx-1">
            <button class="btn btn-outline-info">Go To Categories</button>
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
                    <th>Username</th>
                    <th>Email</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($data as $row)
                <tr class="table-primary" >
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->email }}</td>
                    <td class="text-center">
                        <a href="{{ route('users.details', $row->id) }}"> 
                            <button class="btn btn-outline-info">Details</button>
                        </a>
                        <a href="{{ route('users.edit', $row->id) }}"> 
                            <button class="btn btn-outline-success">Edit</button>
                        </a>
                        <a href="{{ route('users.delete', $row->id) }}"> 
                            <button class="btn btn-outline-danger">Delete</button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@endsection