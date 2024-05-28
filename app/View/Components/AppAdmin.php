<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppAdmin extends Component
{
    public function render(): View
    {
        return view('Admin.layout.app-admin');
    }
}
