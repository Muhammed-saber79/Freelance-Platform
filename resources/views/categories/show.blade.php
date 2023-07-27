@extends('layouts.dashboard')

@section('page-title')
This is <span class="text-success">Category Show</span> page.
@endsection

@section('breadcrumb')
Category Show
@endsection

@section('content')
<div class="ml-2">
    <h3> <span class="text-bold">ID:</span> {{ $category->id }}</h3>
    <h3> <span class="text-bold">Name:</span> {{ $category->name }}</h3>
    <h3> <span class="text-bold">Created At:</span> {{ $category->created_at }}</h3>
    <h3> <span class="text-bold">Parent Category:</span> {{ $category->parent ?? 'No Parent' }}</h3>
</div>
@endsection