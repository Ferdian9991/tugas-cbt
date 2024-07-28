<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get index params.
     * 
     * @param array $searchables
     * @param array $filterables
     * @param array $sortables
     * @return array
     */
    protected function getIndexParams(array $searchables = [], array $filterables = [], array $sortables = []): array
    {
        $page = (int) request()->query('page', 1);
        $limit = (int) request()->query('limit', 10);
        $filter = $this->filterFields($searchables, $filterables);
        $sort = $this->sortFields($sortables);

        return [
            'page' => $page,
            'limit' => $limit,
            'filter' => $filter,
            'sort' => $sort,
        ];
    }

    /**
     * Filter fields.
     * 
     * @param string $search
     * @return array
     */
    protected function filterFields(array $searchables = [], array $filterables = []): array
    {
        $search = request()->query('search');

        // Get filter params
        $filter = $this->getFilterParams();
        $filterables = array_filter($filter, function ($value) use ($filterables) {
            return in_array($value['key'] ?? null, $filterables);
        });

        if (!empty($search) && !empty($searchables)) {
            $filterables[] = [
                'key' => $searchables,
                'value' => $search,
                'operator' => 'ilike',
            ];
        }

        return $filterables;
    }

    /**
     * Sort fields.
     * 
     * @param array $sortables
     * @return array
     */
    protected function sortFields(array $sortables = []): array
    {
        $sort = $this->getSortParams();
        $sortables = array_filter($sort, function ($value) use ($sortables) {
            return in_array($value[0] ?? null, $sortables);
        });

        return $sortables;
    }

    /**
     * Get filter params.
     * @return array
     */
    private function getFilterParams(): array
    {
        $filter = request()->all();

        $filter = array_filter($filter, function ($key) {
            return strpos($key, 'filter_') !== false;
        }, ARRAY_FILTER_USE_KEY);

        $filter = array_map(function ($value, $key) {
            return [
                'key' => str_replace('filter_', '', $key),
                'value' => $value,
                'operator' => '=',
            ];
        }, $filter, array_keys($filter));

        return $filter;
    }

    /**
     * Get filter params.
     * @return array
     */
    private function getSortParams(): array
    {
        $sort = request()->all();

        $sort = array_filter($sort, function ($key) {
            return strpos($key, 'sort_') !== false;
        }, ARRAY_FILTER_USE_KEY);

        $sort = array_map(function ($value, $key) {
            $key = str_replace('sort_', '', $key);
            return [$key, $value];
        }, $sort, array_keys($sort));

        return $sort;
    }
}
