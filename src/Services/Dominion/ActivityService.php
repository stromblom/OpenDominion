<?php

namespace OpenDominion\Services\Dominion;

use OpenDominion\Models\DominionActivity;
use OpenDominion\Models\Realm;

class ActivityService
{
    public function getRealmActivity(Realm $realm): Collection
    {
        return DominionActivity::where(function ($query) use ($realm) {
            $query->where('source_realm_id', '=', $realm->id)
            ->orWhere('target_realm_id', '=', $realm->id);
        })
        ->where('type', '=', 'invasion')
        ->orderBy('created_at', 'desc');
    }
}