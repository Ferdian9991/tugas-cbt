<?php

namespace App\Helpers;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema as BaseSchema;

class Schema extends BaseSchema
{
    /**
     * Create a new table on the schema.
     * 
     * @param string $table
     * @param Closure $callback
     */
    public static function create(string $table, Closure $callback): void
    {
        $schema = DB::getSchemaBuilder();
        $schema->blueprintResolver(function ($table, $callback) {
            return new Blueprint($table, $callback);
        });
        $schema->create($table, $callback);
    }
}
