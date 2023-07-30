@extends('layouts.dashboard')

@section('page-title')
This is <span class="text-success">Create New User</span> page
@endsection

@section('breadcrumb')
create user
@endsection

@section('content')
<x-flash-message />

<form action="{{ route('dashboard.users.store') }}" method='POST' class='my-3'>
    @csrf
    @include('users._form')
    <button type="submit" class='btn btn-outline-primary' [disabled]="!form.form.valid">
        Add
    </button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@endsection