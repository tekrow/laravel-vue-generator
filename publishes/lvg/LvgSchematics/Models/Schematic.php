<?php

namespace Lvg\LvgSchematics\Models;

use Lvg\Core\Models\Field;
use Lvg\Core\Models\Relationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lvg\LvgSchematics\Database\Factories\SchematicFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Schematic extends \Lvg\Core\Models\Schematic
{
    use HasFactory, Searchable;

    protected $fillable = [
        "table_name",
        "model_class",
        "controller_class",
        "route_name",
        "default_label_column",
        "generated_at",
    ];
    protected $hidden = ["password", "remember_token"];
    protected $casts = [
        "generated_at" => "datetime",
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];
    protected $appends = ["can"];

    protected $connection='lvg';
    public function getModuleNameAttribute(): string
    {
        return \Str::pluralStudly($this->model_class);
    }


    /**
     * @return HasMany
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    public function relationships(): HasMany
    {
        return $this->hasMany(Relationship::class,"schematic_id","id");
    }

    protected function getCanAttribute(): array
    {
        $policies = collect([
            "viewAny",
            "view",
            "create",
            "update",
            "delete",
            "restore",
            "forceDelete",
            "review",
        ]);
        return $policies
            ->map(
                fn(string $policy) => [
                    "policy" => $policy,
                    "can" =>
                        \Auth::check() && \Auth::user()->can($policy, $this),
                ]
            )
            ->pluck("can", "policy")
            ->toArray();
    }

    protected static function newFactory(): SchematicFactory
    {
        return SchematicFactory::new();
    }
    /********* BELONGS TO **********/

    /********* MORPH TO **********/

    public function toSearchableArray(): array
    {
        return $this->only($this->getFillable());
    }
}
