@extends('layouts.admin')

@section('content')
    <h2>{{ $project->name }}</h2>

    <div>
        <strong>ID</strong>: {{ $project->id }}
    </div>

    <div>
        <strong>Slug</strong>: {{ $project->slug }}
    </div>

    <div>
        <strong>Type</strong>: {{ $project->type ? $project->type->name : 'none' }}
    </div>

    <div>
        <strong>Technologies</strong>:
        @if (count($project->technologies) > 0)
             @foreach ($project->technologies as $technology)
                 {{ $technology->name }}
             @endforeach
        @else
            No technology assigned yet
        @endif
    </div>

    <div>
        <strong>Client name</strong>: {{ $project->client_name ? $project->client_name : 'empty' }}
    </div>

    <div>
        <strong>Created at</strong>: {{ $project->created_at }}
    </div>

    <div>
        <strong>Update at</strong>: {{ $project->updated_at }}
    </div>

    @if ($project->cover_image)
        <div>
            <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->name }}">
        </div>
    @endif

    <div class="mt-4">
        <strong>Summary</strong>

        <p>{{ $project->summary ? $project->summary : 'No summary' }}</p>
    </div>

    <div class="mt-4">
        <h4>Actions</h4>

        <div>
            <a class="btn btn-primary" href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}">Edit</a>
        </div>

        <div class="mt-2">
            <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
@endsection
