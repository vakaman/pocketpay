<?php

namespace App\Http\Controllers\Pocket;

use App\Domain\Entity\People\Person;
use App\Domain\Entity\People\Type;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Service\PocketManagerServiceInterface;
use App\Domain\ValueObject\Uuid;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct(
        private PocketManagerServiceInterface $pocketManagerService
    ) {
    }

    public function list(): View
    {
        $person = Person::new(
            id: new Uuid(session()->all()['person']->id->value),
            type: new Type(session()->all()['person']->type->id)
        );

        $wallets = $this->pocketManagerService->list($person);

        return view('wallet', ['wallets' => $wallets]);
    }

    public function create(Request $request): RedirectResponse
    {
        $person = Person::new(
            id: new Uuid($request->get('person')),
            type: new Type($request->get('type'))
        );

        $this->pocketManagerService->walletCreate($person);

        return redirect()->back()->with('success', __('Wallet created with success!'));
    }

    public function delete(Request $request): RedirectResponse
    {
        $wallet = new Wallet(id: new Uuid($request->get('wallet')));

        $this->pocketManagerService->walletDelete($wallet);

        return redirect()->back()->with('success', __('Wallet deleted with success!'));
    }
}
