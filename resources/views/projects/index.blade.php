<x-app-layout title="Client">
    <!-- Row -->
    <div class="row">

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">
                <x-flash-message />

                @if (Session::has('error'))
                    <h5 class="text-danger">
                        {{ Session::get('error') }}
                    </h5>
                @endif
                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-business-center"></i> My Job Listings
                    <small><a href="{{ route('client.projects.create') }}" class="btn btn-sm btn-outline-primary">Post Job</a></small></h3>
                </div>

                <div class="content">
                    <ul class="dashboard-box-list">
                        @foreach ($projects as $project)
                        <li>
                            <!-- Job Listing -->
                            <div class="job-listing">

                                <!-- Job Listing Details -->
                                <div class="job-listing-details">

                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title"><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a> <span class="dashboard-status-button yellow">{{ $project->status }}</span></h3>

                                        <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-date-range"></i> Posted on {{ $project->created_at }}</li>
                                                
                                                @if ($project->category)
                                                    <li>
                                                        <i class="icon-material-outline-bookmarks"></i>
                                                        Category: {{ $project->category->parent ? $project->category->parent->name . ' / ' : 'No Category' }}
                                                                {{ $project->category->name }}
                                                    </li>
                                                @endif

                                                <li><i class="icon-material-outline-bookmarks"></i>  
                                                    Tags: 
                                                    @foreach ($project->tags as $tag)
                                                        <span style="color:cornflowerblue;">#{{ $tag->name }}</span>
                                                    @endforeach
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="buttons-to-right always-visible">
                                <a href="dashboard-manage-candidates.html" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Candidates <span class="button-info">3</span></a>
                                <a href="{{ route('client.projects.edit', $project->id) }}" class="button gray ripple-effect ico" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                <a 
                                    class="button gray ripple-effect ico" 
                                    title="Remove" 
                                    data-tippy-placement="top"
                                    onClick="if(confirm('Are you sure you want to delete this project?')) {
                                            document.getElementById('delete-project').submit()
                                    }">
                                    <i class="icon-feather-trash-2"></i>
                                </a>
                                <form id='delete-project' action="{{ route('client.projects.destroy', $project->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                {{ $projects->withQueryString()->links('vendor.pagination.default') }}
            </div>
        </div>

    </div>
    <!-- Row / End -->
</x-app-layout>