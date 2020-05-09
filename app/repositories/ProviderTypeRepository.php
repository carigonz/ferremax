<?php
namespace App\Repositories;

use App\Models\ProviderType;
use Illuminate\Support\Collection;

class ProviderTypeRepository extends AbstractRepository
{
    function __construct(ProviderType $model)
    {
        $this->model = $model;
    }
    /**
     * @param array $params
     * @param bool $count
     * @param bool $distinct
     * @return Provider|int
     */
    public function search($params = [], $count = false, $distinct = true)
    {
        $joins = collect();
        $query = $this->model;

        if($distinct){
            $query->distinct('provider_types.id');
        }

        if (isset($params['id']) && $params['id']) {
            if (is_array($params['id']) && !empty($params['id'])) {
                return $query->whereIn('providers.id', $params['id']);
            } else {
                return !$params['id'] ? $query : $query->where('providers.id', $params['id']);
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
            return $query->count('provider_types.id');
        }

        $joins->each(function ($item, $key) use (&$query) {
            $item = json_decode($item);
            $query->join($key, $item->first, '=', $item->second, $item->join_type);
        });

        return $query->orderBy('type', 'asc');
    }
}