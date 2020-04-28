<?php
namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProducttRepository extends AbstractRepository
{
    function __construct(Product $model)
    {
        $this->model = $model;
    }
    /**
     * @param array $params
     * @param bool $count
     * @param bool $distinct
     * @return Product|int
     */
    public function search($params = [], $count = false, $distinct = true)
    {
        $joins = collect();
        $query = $this->model
            ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->select('products.*')
            ->addSelect('suppliers.name');

        if($distinct){
            $query->distinct('products.id');
        }

        if (isset($params['id']) && $params['id']) {
            if (is_array($params['id']) && !empty($params['id'])) {
                return $query->whereIn('products.id', $params['id']);
            } else {
                return !$params['id'] ? $query : $query->where('products.id', $params['id']);
            }
        }

        if (isset($params['supplier_id']) && $params['supplier_id']) {
            $query->ofSupplierId($params['supplier_id']);
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
            return $query->count('product.id');
        }

        $joins->each(function ($item, $key) use (&$query) {
            $item = json_decode($item);
            $query->join($key, $item->first, '=', $item->second, $item->join_type);
        });

        return $query->orderBy('products.name', 'asc');
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