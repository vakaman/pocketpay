<?php

namespace App\Http\Controllers;

use App\Domain\Service\PocketManagerServiceInterface;
use Illuminate\View\View;

class Dashboard extends Controller
{
    public function __construct(
        private PocketManagerServiceInterface $pocketManagerService
    ) {
    }
    public function index(): View
    {
        $transactions = $this->pocketManagerService->history(
            session()->all()['person']
        );

        return view('dashboard', [
            'transactions' => $transactions
        ]);
    }
}
