<?php

namespace OpenDominion\Models;

class DominionActivity extends AbstractModel // todo: AbstractReadOnlyModel
{
    protected $casts = [
        'source_dominion_id' => 'int',
        'target_dominion_id' => 'int',
        'data' => 'array',
    ];

    public function sourceRealm()
    {
        return $this->belongsTo(Realm::class, 'source_realm_id');
    }

    public function targetRealm()
    {
        return $this->belongsTo(Realm::class, 'target_realm_id');
    }

    public function sourceDominion()
    {
        return $this->belongsTo(Dominion::class, 'source_dominion_id');
    }

    public function targetDominion()
    {
        return $this->belongsTo(Dominion::class, 'target_dominion_id');
    }
}