<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use App\Models\Technology;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();

        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|max:250|unique:projects,name',
            'client_name' => 'nullable|min:5',
            'summary' => 'nullable|min:20',
            'cover_image' => 'nullable|image|max:256',
            'type_id' => 'nullable|exists:types,id'
        ]);

        $formData = $request->all();

        if($request->hasFile('cover_image')) {
            // Fare l'upload del file nella cartella pubblica
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);
            // Salvare nel db il path del file caricato nella colonna cover_image
            $formData['cover_image'] = $img_path;
        }
        
        $newProject = new Project();
        $newProject->slug = Str::slug($formData['name'], '-');
        $newProject->fill($formData);
        $newProject->save();

        return redirect()->route('admin.projects.show', ['project' => $newProject->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();

        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => [
                'required',
                'min:5',
                'max:250',
                Rule::unique('projects')->ignore($project)
            ],
            'client_name' => 'nullable|min:5',
            'summary' => 'nullable|min:20',
            'cover_image' => 'nullable|image|max:256',
            'type_id' => 'nullable|exists:types,id'
        ]);
        
        $formData = $request->all();

        if($request->hasFile('cover_image')) {
            // Se c'è l'immagine vecchia la cancello dalla cartella
            if($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            // Fare l'upload del file nella cartella pubblica
            $img_path = Storage::disk('public')->put('project_images', $formData['cover_image']);
            // Salvare nel db il path del file caricato nella colonna cover_image
            $formData['cover_image'] = $img_path;
        }

        $formData['slug'] = Str::slug($formData['name'], '-');
        $project->update($formData);

        return redirect()->route('admin.projects.show', ['project' => $project->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }
}
