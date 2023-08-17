<?php

namespace App\Http\Controllers\Client;

use App\Models\Tag;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Client\ProjectRequest;
use Exception;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        /**
         * To get all projects we have 2 solutions:
         *  => First one { get by using 'where' and 'pagination' }
         */
        // $projects = Project::where('user_id', '=', $user->id)->paginate(3);

        /**
         *  => Second one { get by using 1->m relation 'projects' but without pagination }
         */
        // $projects = $user->projects;                   //Without Pagination
        $projects = $user->projects()->with('category', 'tags')->paginate(3);     //With Pagination

        return view('client.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        // $types = ['hourly', 'fixed'];
        $types = Project::types();
        $categories = $this->categories();
        $tags = [];

        return view('client.projects.create', compact('project', 'types', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $user = $request->user();
        $data = $request->except('attachments');

        $attachments = $this->uploadAttachments($request);
        $data['attachments'] = $attachments;

        // This is the first way.
        // $request->merge([
        //     // 'user_id' => Auth::user()->id
        //     'user_id' => $user->id,
        //     'category_id' => 1
        // ]);
        // $project = Project::create($request->all());

        // The second way.
        $project = $user->projects()->create($data);

        $tags = explode(',', $request->input('tags'));
        $project->syncTags($tags);
        
        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Auth::user()->projects()->findOrFail($id);

        return view('client.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Auth::user()->projects()->findOrFail($id);

        // $types = ['hourly', 'fixed'];
        $types = Project::types();
        $categories = $this->categories();
        $tags = $project->tags->pluck('name')->all();

        return view('client.projects.edit', compact('project', 'types', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        $project = Auth::user()->projects()->findOrFail($id);
        $data = $request->except('attachments');

        $attachments = $this->uploadAttachments($request);
        $data['attachments'] = array_merge( ($project->attachments ?? []), ($attachments ?? []));

        $project->update($data);

        $tags = explode(',', $request->input('tags'));
        $project->syncTags($tags);

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       try {
            // This is the first way {by using 'projects' relation}
            $project = Auth::user()->projects()->findOrFail($id);
            if (!$project) {
                throw new Exception('Project not found...!');
            }

            // dd($project->attachments);
            foreach ($project->attachments as $file) {
                Storage::disk('uploads')->delete($file);
            }

            $project->delete();

            // This is the second way {by using 'Project' model}
            // Project::where('user_id', Auth::id())
            //     ->where('id', $id)
            //     ->delete();

            return redirect()
                ->route('client.projects.index')
                ->with('success', 'Project deleted successfully.');

       } catch ( Exception $e ) {
            return redirect()
                ->route('client.projects.index')
                ->with('error', 'An Error Occured: ' . $e->getMessage());
       }
    }

    protected function categories () {
        return Category::pluck('name', 'id')->toArray(); 
    }

    /**
     * File Upload
     */
    protected function uploadAttachments ( Request $request ) {
        if (!$request->hasFile('attachments')) {
            return;
        }

        $files = $request->file('attachments');
        $attachments = [];

        foreach ($files as $file) {
            if ($file->isValid()) {
                $path = $file->store('/attachments', [
                    'disk' => 'uploads',
                ]);

                $attachments[] = $path;
            }
        }

        return $attachments;
    }
}
