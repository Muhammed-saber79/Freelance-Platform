@extends('layouts.dashboard')

@section('page-title')
This is <span class="text-success">Edit Category</span> page.
@endsection

@section('breadcrumb')
Category Edit
@endsection

@section('content')
<div class="container">
    <x-flash-message />

    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST">
        @csrf    
        @method('PUT')
        @include('categories._form')
        <button class="btn btn-outline-primary">Update</button>
    </form>
</div>    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
@endsection