<?php

namespace OpenDominion\Services;

use OpenDominion\Models\Dominion;
use OpenDominion\Models\Pack;
use OpenDominion\Models\Race;
use OpenDominion\Models\Round;
use RuntimeException;

class PackService
{
    public function createPack(Dominion $dominion, string $packName, string $packPassword, int $packSize): Pack
    {
        if (($packSize < 2) || ($packSize > $dominion->round->pack_size)) {
            throw new RuntimeException("Pack size must be between 2 and {$dominion->round->pack_size}.");
        }

        return Pack::create([
            'round_id' => $dominion->round->id,
            'realm_id' => $dominion->realm->id,
            'creator_dominion_id' => $dominion->id,
            'name' => $packName,
            'password' => $packPassword,
            'size' => $packSize,
        ]);
    }

    public function getPack(Round $round, Race $race, string $packName, string $packPassword): ?Pack
    {
        $pack = Pack::where([
            'round_id' => $round->id,
            'name' => $packName,
            'password' => $packPassword,
        ])->withCount('dominions')->first();

        if (!$pack) {
            return null;
        }

        if ($pack->dominions_count >= $pack->size) {
            throw new RuntimeException('Pack is already full');
        }

        if ($pack->realm->alignment !== $race->alignment) {
            throw new RuntimeException('Race has wrong alignment to the rest of pack.');
        }

        return $pack;
    }
}
