@extends('layouts.dashboard')

@section('page-title')
This is <span class="text-success">Create Category</span> page.
@endsection

@section('breadcrumb')
Category Create
@endsection

@section('content')
<div class="container">
    <x-flash-message />

    <form action="{{ route('dashboard.categories.store') }}" method="POST">
        @csrf    
        @include('categories._form')
        <button class="btn btn-outline-primary">Create</button>
    </form>
</div>    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@endsection