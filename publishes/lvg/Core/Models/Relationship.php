<?php

namespace Lvg\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Relationship extends Model
{
    protected $guarded = 'id';
    protected $connection='lvg';
    public function schematic(): BelongsTo
    {
        return $this->belongsTo(Schematic::class);
    }
    public function related(): BelongsTo
    {
        return $this->belongsTo(Schematic::class,"related_id");
    }
}
