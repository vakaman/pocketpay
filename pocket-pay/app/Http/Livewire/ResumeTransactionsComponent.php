<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ResumeTransactionsComponent extends Component
{
    public $loading = false;

    public $responseData = null;

    public function fetchData()
    {
        $this->loading = true;

        // Make your API request here
        $response = Http::get(env('API_POCKET_MANAGER'). '/api/transaction/history');

        $this->responseData = $response->json();
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.resume-transactions-component');
    }
}
