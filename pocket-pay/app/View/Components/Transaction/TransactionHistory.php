<?php

namespace App\View\Components\Transaction;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TransactionHistory extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.transaction-history');
    }
}
