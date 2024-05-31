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
        <strong>Client name</strong>: {{ $project->client_name ? $project->client_name : 'empty' }}
    </div>

    <div>
        <strong>Created at</strong>: {{ $project->created_at }}
    </div>

    <div>
        <strong>Update at</strong>: {{ $project->updated_at }}
    </div>

    <div class="mt-4">
        <strong>Summary</strong>

        <p>{{ $project->summary ? $project->summary : 'No summary' }}</p>
    </div>
@endsection
