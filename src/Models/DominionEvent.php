<?php

namespace OpenDominion\Models;

class DominionEvent extends AbstractModel // todo: AbstractReadOnlyModel
{
    protected $casts = [
        'source_dominion_id' => 'int',
        'target_dominion_id' => 'int',
        'data' => 'array',
    ];

    public function sourceDominion()
    {
        return $this->belongsTo(Dominion::class, 'source_dominion_id');
    }

    public function targetDominion()
    {
        return $this->belongsTo(Dominion::class, 'target_dominion_id');
    }
}