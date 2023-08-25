<?php

namespace App\View\Components\Alerts;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Success extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.alerts.success');
    }
}
