<x-app-layout title="Post Job">
    <form action="{{ route('client.projects.store') }}" method="POST">
        @csrf
        @include('client.projects._form')
    </form>
</x-app-layout>