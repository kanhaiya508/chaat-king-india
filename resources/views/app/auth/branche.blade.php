<x-layouts.auth title="Select Branch">

    <div class="container mt-3">
        <div class="card shadow-sm ">
            <div class="card-body">
                <h4 class="mb-3 select-branch-header">
                    <i class="ri-community-line me-2"></i> Select Branch
                </h4>

                @if ($branches->count())
                    <div class="tiles-gap">
                        @foreach ($branches as $branch)
                            <div class="branch-tile  mb-2 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="branch-icon">
                                        <i class="ri-building-2-line"></i>
                                    </div>
                                    <div>
                                        <p class="branch-name mb-1">{{ $branch->name }}</p>
                                        @if ($currentBranchId == $branch->id)
                                            <span class="badge badge-current">Current</span>
                                        @endif
                                    </div>
                                </div>

                                <form action="{{ route('branches.switch', $branch) }}" method="POST" class="ms-3">
                                    @csrf
                                    <button type="submit" class="btn-branch"
                                        {{ $currentBranchId == $branch->id ? 'disabled' : '' }}>
                                        <i class="ri-exchange-funds-line"></i>
                                        Switch
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    {{-- Go to Dashboard Button --}}
                    <div class="mt-3 text-end">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="ri-dashboard-line me-1"></i> Go to Dashboard
                        </a>
                    </div>
                @else
                    <div class="text-center text-muted py-3">
                        No branches assigned to your account.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.auth>
