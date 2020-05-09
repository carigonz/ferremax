<?php
namespace App\Repositories;

use App\Models\Classification;
use Illuminate\Support\Collection;

class ClassificationRepository extends AbstractRepository
{
    function __construct(Classification $model)
    {
        $this->model = $model;
    }
    /**
     * @param array $params
     * @param bool $count
     * @param bool $distinct
     * @return Classification|int
     */
    public function search($params = [], $count = false, $distinct = true)
    {
        $joins = collect();
        $query = $this->model
            ->select('classifications.*');

        if($distinct){
            $query->distinct('classifications.id');
        }

        if (isset($params['id']) && $params['id']) {
            if (is_array($params['id']) && !empty($params['id'])) {
                return $query->whereIn('classifications.id', $params['id']);
            } else {
                return !$params['id'] ? $query : $query->where('classifications.id', $params['id']);
            }
        }

        if (isset($params['type']) && $params['type']) {
            $query->ofType($params['type']);
        }

        // if (isset($params['country_id']) && $params['country_id']) {
        //     $this->addJoin($joins, 'services', 'services.id', 'agreements.service_id');
        //     $this->addJoin($joins, 'locations as destination_locations', 'destination_locations.id', 'services.destination_location_id', 'left outer');
        //     $query->ofDestinationCountryId($params['country_id']);
        // }

        // if (isset($params['country_id']) && $params['country_id']) {
        //     $this->addJoin($joins, 'countries', 'taxes.country_id', 'countries.id');
        //     $query->ofCountryId($params['country_id']);
        // }

        if($count){
            return $query->count('classifications.id');
        }

        $joins->each(function ($item, $key) use (&$query) {
            $item = json_decode($item);
            $query->join($key, $item->first, '=', $item->second, $item->join_type);
        });

        return $query->orderBy('classifications.type', 'asc');
    }

    /**
     * @param Collection $joins
     * @param $table
     * @param $first
     * @param $second
     * @param string $join_type
     */
    private function addJoin(Collection &$joins, $table, $first, $second, $join_type = 'inner')
    {
        if (!$joins->has($table)) {
            $joins->put($table, json_encode(compact('first', 'second', 'join_type')));
        }
    }
}