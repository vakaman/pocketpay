<?php

namespace App\View\Components\Wallets;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class WalletsList extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.tables.wallets-list');
    }
}
