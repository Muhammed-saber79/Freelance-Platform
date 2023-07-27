@extends('layouts.dashboard')

@section('page-title')
This is <span class="text-success">Edit User's Data</span> page
@endsection

@section('breadcrumb')
edit user
@endsection

@section('content')
<x-flash-message />

<form action="{{ route('users.update', $user->id) }}" method='POST' class='my-3'>
    @csrf
    @method('PUT')
    @include('users._form')
    <button type="submit" class='btn btn-outline-primary' [disabled]="!form.form.valid">
        Update
    </button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@endsection