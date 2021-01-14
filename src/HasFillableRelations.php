<?php

namespace Likemusic\Laravel\FillableRelationsPatch;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaravelFillableRelations\Eloquent\Concerns\HasFillableRelations as BaseHasFillableRelations;

trait HasFillableRelations
{
    use BaseHasFillableRelations;

    public function extractFillableRelations(array $attributes)
    {
        $relationsAttributes = [];

        foreach ($this->fillableRelations() as $relationName) {
            $val = Arr::pull($attributes, $relationName);

            if ($val === null) {
                $snakeRelationName = Str::snake($relationName);
                $val = Arr::pull($attributes, $snakeRelationName);
            }

            if ($val !== null) {
                $relationsAttributes[$relationName] = $val;
            }
        }

        return [$relationsAttributes, $attributes];
    }
}
