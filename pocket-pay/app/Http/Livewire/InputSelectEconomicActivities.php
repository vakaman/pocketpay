<?php

namespace App\Http\Livewire;

use App\Models\EconomicActivitie;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class InputSelectEconomicActivities extends Component
{
    public $types;

    public $selectedPersonType = 1;

    protected $listeners = ['attribute-updated' => 'handleSelectedPersonType'];

    public function mount()
    {
        $this->selectedPersonType = 1;
    }

    public function handleSelectedPersonType($data)
    {
        $this->selectedPersonType = $data['selectedPersonType'];
    }

    public function render()
    {
        Log::info($this->selectedPersonType);
        return view('livewire.input-select-economic-activities', [
            'economicActivities' => EconomicActivitie::where('type_id', '=', $this->selectedPersonType)->get()
        ]);
    }
}
