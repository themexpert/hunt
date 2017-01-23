<?php

namespace App\Concerns;

trait DataWithPagination
{
    /**
     * Get data with pagination.
     *
     * @param \Illuminate\Support\Collection $data
     * @param int $limit
     * @param string $orderBy
     * @param string $column
     *
     * @return array
     */
    public function dataWithPagination($data, $limit, $orderBy = 'desc', $column = "id")
    {
        $limit = empty($limit)? 10 : (int) $limit;

        $data = $data->orderBy($column, $orderBy)
            ->paginate($limit)
            ->toArray();

        return [
            'data' => $data['data'],
            'pagination'  => [
                'limit'         => $limit,
                'total_count'   => $data['total'],
                'total_page'    => ceil($data['total'] / $data['per_page']),
                'current_page'  => $data['current_page'],
                'from'          => $data['from'],
                'to'            => $data['to']
            ]
        ];
    }
}