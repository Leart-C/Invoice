<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public array $navItems;

    public function __construct()
    {
        $this->navItems = config('navigation.sidebar');
    }

    public function render()
    {
        return view('components.layouts.sidebar');
    }
}