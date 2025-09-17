<!-- Branch Switcher -->
<li class="nav-item dropdown  me-2 ">
    <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill" id="nav-branch"
        href="javascript:void(0);" data-bs-toggle="dropdown">
        <i class="fa-solid fa-building text-heading"></i>
        <span class="d-none ms-2" id="nav-branch-text">
            {{ session('branch_id') ? optional($branches->firstWhere('id', session('branch_id')))->name : 'Select Branch' }}
        </span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-branch-text">
        @forelse($branches as $branch)
            <li>
                <form method="POST" action="{{ route('branches.switch', $branch->id) }}">
                    @csrf
                    <button type="submit"
                        class="dropdown-item align-items-center {{ session('branch_id') == $branch->id ? 'active' : '' }}">
                        <i class="fa-solid fa-code-branch me-3"></i>
                        {{ $branch->name }}
                    </button>
                </form>
            </li>
        @empty
            <li><span class="dropdown-item text-muted">No Branch Found</span></li>
        @endforelse
    </ul>
</li>
<!-- / Branch Switcher -->
