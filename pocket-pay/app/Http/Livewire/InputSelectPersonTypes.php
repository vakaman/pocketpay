<?php

namespace App\Http\Livewire;

use App\Models\Type;
use Livewire\Component;

class InputSelectPersonTypes extends Component
{
    public $types;

    public $selectedPersonType;

    protected $rules = [
        'types' => 'required',
    ];

    public function __construct()
    {
        $this->types = Type::all();
    }

    public function updatedSelectedPersonType($value)
    {
        $this->selectedPersonType = $value;
        $this->emit('attribute-updated', ['selectedPersonType' => $this->selectedPersonType]);
    }

    public function render()
    {
        return view('livewire.input-select-person-types');
    }
}
