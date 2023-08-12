<?php

namespace App\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use App\Service\PocketService;

class PocketController extends Controller
{
    public function __construct(
        private PocketService $pocketService
    ) {
    }

}
