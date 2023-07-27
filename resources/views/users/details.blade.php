@extends('layouts.dashboard')

@section('page-title')
This is <span class="text-success">User Details</span> page
@endsection

@section('breadcrumb')
user details
@endsection

@section('content')
<div class="ml-5">
    <h4>ID: {{ $user->id }}</h4><br>
    <h4>Name: {{ $user->name }}</h4><br>
    <h4>Email: {{ $user->email }}</h4><br>
    <h4>Password: {{ $user->password }}</h4><br>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@endsection