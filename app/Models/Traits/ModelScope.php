<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ModelScope
{
    /**
     * Build query for filter.
     *
     * @param Builder $query
     * @param mixed $column
     * @param mixed $value
     * @param mixed $operator
     * @param array $map
     */
    protected function queryFilter(
        Builder $query,
        mixed $column,
        mixed $value,
        mixed $operator = null,
        array $map = []
    ) {
        if (empty($operator)) {
            $operator = 'ilike';
        }

        if (in_array($operator, ['ilike', 'like'])) {
            $value = '%' . $value . '%';
        }


        if (is_array($column)) {
            $this->queryFilterArray($query, $column, $value, $operator, $map);
        } else {
            if ($operator == 'in') {
                $query->whereIn($this->getColumnDefinition($column, $map), $value);
            } else if ($operator == 'not in') {
                $query->whereNotIn($this->getColumnDefinition($column, $map), $value);
            } else {
                $query->where(function ($query) use ($column, $value, $operator, $map) {
                    $this->queryFilterWhere($query, $column, $value, $operator, $map);
                });
            }
        }
    }

    /**
     * Build query for multiple filter.
     *
     * @param Builder $query
     * @param mixed $column
     * @param mixed $value
     * @param mixed $operator
     * @param array $map
     */
    protected function queryFilterArray(
        Builder $query,
        array $column,
        mixed $value,
        mixed $operator = null,
        array $map = []
    ) {
        $query->where(function ($query) use ($column, $value, $operator, $map) {
            $query->where(function ($query) use ($column, $value, $operator, $map) {
                $this->queryFilterWhere(
                    $query,
                    $column[0],
                    is_array($value) ? $value[0] : $value,
                    is_array($operator) ? $operator[0] : $operator,
                    $map
                );
            });

            for ($i = 1; $i < count($column); $i++) {
                $query->orWhere(function ($query) use ($column, $value, $operator, $map, $i) {
                    $this->queryFilterWhere(
                        $query,
                        $column[$i],
                        is_array($value) ? $value[$i] : $value,
                        is_array($operator) ? $operator[$i] : $operator,
                        $map
                    );
                });
            }
        });
    }

    /**
     * Get column definition.
     *
     * @param string $column
     * @param array $map
     * @return string
     */
    protected function getColumnDefinition(string $column, array $map = []): string
    {
        // cek map
        if (!empty($map[$column])) {
            return $map[$column];
        }

        return $column;
    }

    protected static function getTableName()
    {
        $self = new static();

        return $self->getTable();
    }

    /**
     * Build query for filter condition.
     *
     * @param Builder $query
     * @param string $column
     * @param mixed $value
     * @param mixed $operator
     * @param array $map
     */
    protected function queryFilterWhere(
        Builder $query,
        string $column,
        mixed $value,
        mixed $operator = null,
        array $map = []
    ) {
        // bisa di-extend untuk custom
        $query->where($this->getColumnDefinition($column, $map), $operator, $value);
    }

    /**
     * Scope a query to sort.
     * 
     * @param Builder $query
     * @param string $sort
     * 
     * @return void
     */
    public function scopeSortPage($query, $sort)
    {
        if (empty($sort)) {
            return;
        }

        foreach ((array)$sort as $v) {
            $v = (array)$v;
            $this->sortPage($query, $v[0], $v[1] ?? null);
        }
    }

    /**
     * Sort page.
     * 
     * @param Builder $query
     * @param string $column
     * @param string $direction
     * 
     * @return void
     */
    protected function sortPage($query, $column, $direction = null)
    {
        $query->orderByRaw($this->getColumnDefinition($column) . (empty($direction) ? '' : ' ' . $direction));
    }

    /**
     * Scope a query to filter.
     *
     * @param Builder $query
     * @param array $filter
     * @param array $map
     */
    public function scopeFilterPage(Builder $query, array $filter, array $map = [])
    {
        if (empty($filter)) {
            return;
        }

        foreach ($filter as $v) {
            $this->queryFilter($query, $v['key'], $v['value'], $v['operator'] ?? null, $map);
        }
    }
}
