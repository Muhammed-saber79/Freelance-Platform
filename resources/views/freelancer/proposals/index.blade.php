<x-app-layout title="Proposals">
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
                    <h3><i class="icon-material-outline-business-center"></i> My Proposals
                </div>

                <div class="content">
                    <ul class="dashboard-box-list">
                        @foreach ($proposals as $proposal)
                        <li>
                            <!-- Job Listing -->
                            <div class="job-listing">

                                <!-- Job Listing Details -->
                                <div class="job-listing-details">

                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title"><a href="#">{{ $proposal->project->title }}</a> <span class="dashboard-status-button yellow">{{ $proposal->status }}</span></h3>

                                        <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-date-range"></i> Posted on {{ $proposal->created_at->diffForHumans() }}</li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="buttons-to-right always-visible">
                                <a href="dashboard-manage-candidates.html" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Candidates <span class="button-info">3</span></a>
                                <a href="{{ route('freelancer.proposals.edit', $proposal->id) }}" class="button gray ripple-effect ico" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                <a 
                                    class="button gray ripple-effect ico" 
                                    title="Remove" 
                                    data-tippy-placement="top"
                                    onClick="if(confirm('Are you sure you want to delete this project?')) {
                                            document.getElementById('delete-proposal').submit()
                                    }">
                                    <i class="icon-feather-trash-2"></i>
                                </a>
                                <form id='delete-proposal' action="{{ route('freelancer.proposals.destroy', $proposal->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                {{ $proposals->withQueryString()->links('vendor.pagination.default') }}
            </div>
        </div>

    </div>
    <!-- Row / End -->
</x-app-layout>