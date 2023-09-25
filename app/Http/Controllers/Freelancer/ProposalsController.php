<?php

namespace App\Http\Controllers\Freelancer;

use App\Models\Admin;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewProposalNotification;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProposalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('web')->user();
        $proposals = $user->proposals()
            ->with('project')
            ->latest()
            ->paginate();

        return view('freelancer.proposals.index', [
            'proposals' => $proposals
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id)
    {
        $project = Project::findOrFail($project_id);

        return view('freelancer.proposals.create', [
            'project' => $project,
            'proposals' => new Proposal(),
            'units' => Proposal::units(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        if ($project->status !== 'open') {
            return redirect()
                ->route('freelancer.proposals.index')
                ->with('error', 'You can not submit a proposal to this project...!');
        }

        $user = Auth::guard('web')->user();
        if ($user->proposedProjects()->find($project_id)) {
            return redirect()
                ->route('freelancer.proposals.index')
                ->with('error', 'You have already submitted a proposal for this project before...!');
        }

        $request->validate([
            'description' => ['required', 'string'],
            'cost' => ['required', 'numeric', 'min:1'],
            'duration' => ['required', 'int', 'min:1'],
            'duration_unit' => ['required', 'in:day,week,month,year'],
            'description' => ['required', 'string'],
        ]);

        $request->merge([
            'project_id' => $project_id
        ]);

        $proposal = $user->proposals()->create( $request->all() );

        // Notifications logic will be here.
        $project->client->notify(new NewProposalNotification($proposal, $user));

        // Notify All Admins...
        /*$admins = Admin::all();
        Notification::send($admins, new NewProposalNotification($proposal, $user));*/

        // On Demand Notifications...
        /*Notification::route('mail', 'mohaamed.sabeer20@gmail.com')
            ->notify(new NewProposalNotification($proposal, $user));*/

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Proposal submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        try {
            $user->proposals()->where('id', $id)->delete();
            return redirect()
                ->route('freelancer.proposals.index')
                ->with('success', 'Proposal removed successfully.');
        } catch (Exception $e) {
            return redirect()
                ->route('freelancer.proposals.index')
                ->with('error', $e->getMessage());
        }
    }
}
