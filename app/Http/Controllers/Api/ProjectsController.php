<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Client\ProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::latest()
            ->with([
                'client:id,name',
                'category:id,name',
                'tags:id,name'
            ])
            ->paginate(10);
        return $projects;
    }

    public function store(ProjectRequest $request)
    {
        // $user = $request->user();
        $user = User::find(1);

        // $attachments = $this->uploadAttachments($request);
        // $data['attachments'] = $attachments;
        $data = $request->except('attachments');
        $project = $user->projects()->create($data);

        $tags = explode(',', $request->input('tags'));
        $project->syncTags($tags);

        return response()->json(['message' => 'Project created successfully', 'data' => $project], 201);
    }

    public function show(Project $project) //string $id)
    {
        // return $project->load([
        //     'client:id,name',
        //     'category:id,name',
        //     'tags:id,name'
        // ]);

        // Here we will use ProjectResource to return json data...
        return new ProjectResource($project);
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max: 255'],
            'description' => ['sometimes', 'required', 'string'],
            'type' => ['sometimes', 'required', 'in:hourly,fixed'],
            'budget' => ['nullable', 'numeric', 'min:0'],
        ]);

        $project->update($data);

        return response()->json(['message' => 'Project updated successfully', 'data' => $project], 200);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        
        if ($project->attachments) {
            foreach($project->attachments as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        return [
            'message' => 'Project deleted successfully.'
        ];
    }
}
