<?php

namespace MrwangTc\Searchable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Search extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function searchable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeWithType(Builder $query, string $type)
    {
        return $query->where('searchable_type', app($type)->getMorphClass());
    }

}