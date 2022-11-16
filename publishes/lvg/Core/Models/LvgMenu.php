<?php

namespace Lvg\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lvg\Core\Database\factories\LvgMenuFactory;

class LvgMenu extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'menus';
    protected $connection='lvg';

    protected static function newFactory(): LvgMenuFactory
    {
        return LvgMenuFactory::new();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class,'parent_id');
    }
    public function children() : HasMany {
        return $this->hasMany(static::class,"parent_id");
    }
}
