<x-app-layout title="Post Job">
    <form action="{{ route('client.projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('client.projects._form')
    </form>
</x-app-layout>