@extends('layouts.admin')

@section('content')
    <h2>Projects</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Client name</th>
                <th scope="col">Created at</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->client_name }}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>
                        <div>
                            <a href="{{ route('admin.projects.show', ['project' => $project->slug]) }}">View</a>
                        </div>

                        <div>
                            <a href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}">Edit</a>
                        </div>

                        <div>
                            <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
@endsection