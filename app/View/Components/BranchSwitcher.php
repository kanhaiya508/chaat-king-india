<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BranchSwitcher extends Component
{
    public $branches;

    public function __construct()
    {
        // agar user login hai toh uske branches lo
        $this->branches = auth()->check() ? auth()->user()->branches()->orderBy('id')->get() : collect();
    }

    public function render()
    {
        return view('components.branch-switcher');
    }
}
