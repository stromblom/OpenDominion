<?php

namespace OpenDominion\Http\Controllers\Dominion;

use OpenDominion\Models\Realm;
use OpenDominion\Services\GameEventService;

class TownCrierController extends AbstractDominionController
{
    public function getIndex(int $realmNumber = null)
    {
        $gameEventService = app(GameEventService::class);

        $dominion = $this->getSelectedDominion();

        if ($realmNumber !== null) {
            $realm = Realm::where([
                'round_id' => $dominion->round_id,
                'number' => $realmNumber,
            ])
            ->first();
        } else {
            $realm = null;
        }

        $townCrierData = $gameEventService->getTownCrier($dominion, $realm);

        $gameEvents = $townCrierData['gameEvents'];
        $dominionIds = $townCrierData['dominionIds'];

        return view('pages.dominion.town-crier', compact(
            'gameEvents',
            'realm',
            'dominionIds'
        ))->with('fromOpCenter', false);
    }
}
