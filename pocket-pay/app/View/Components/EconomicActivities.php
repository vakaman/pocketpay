<?php

namespace App\View\Components;

use App\Models\EconomicActivitie;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EconomicActivities extends Component
{
    public function __construct(
        private string $type = ''
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.economic-activities', [
            'economicActivities' => EconomicActivitie::all()
        ]);
    }
}
