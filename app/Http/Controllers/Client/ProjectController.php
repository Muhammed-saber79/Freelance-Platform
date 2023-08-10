<?php

namespace App\Http\Controllers\Client;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

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
        $projects = Project::where('user_id', '=', $user->id)->paginate();
        // dd($projects);
        /**
         *  => Second one { get by using 1->m relation 'projects' but without pagination }
         */
        // $projects = $user->projects;                   //Without Pagination
        // $projects = $user->projects()->paginate();     //With Pagination

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
    public function store(Request $request)
    {
        $user = $request->user();

        // This is the first way.
        // $request->merge([
        //     // 'user_id' => Auth::user()->id
        //     'user_id' => $user->id,
        //     'category_id' => 1
        // ]);
        // $project = Project::create($request->all());

        // The second way.
        // dd($request->all());
        $project = $user->projects()->create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'budget' => $request->budget,
            'user_id' => $user->id,
        ]);

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
        $tags = [];

        return view('client.projects.edit', compact('project', 'types', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        $project = Auth::user()->projects()->findOrFail($id);
        $project->update($request->all());


        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // This is the first way {by using 'projects' relation}
        $project = Auth::user()->projects()->where('id', $id)->delete();

        // This is the second way {by using 'Project' model}
        // Project::where('user_id', Auth::id())
        //     ->where('id', $id)
        //     ->delete();

        return redirect()
            ->route('client.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    protected function categories () {
        return Category::pluck('name', 'id')->toArray(); 
    }
}
