<?php

namespace App\Filters;

use System\Http\Request;
use NilPortugues\Sql\QueryBuilder\Manipulation\AbstractBaseQuery;

abstract class Filter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var AbstractBaseQuery
     */
    protected $builder;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $fieldsOrder = [];

    /**
     * ThreadFilter constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * @return array
     */
    protected function getFilters(): array
    {
        return array_filter($this->request->get($this->filters));
    }

    /**
     * @param $value
     *
     * @return AbstractBaseQuery
     */
    protected function order($value)
    {
        $order = explode(':', $value);
        $order[1] = !empty($order[1]) && in_array($order[1], ['asc', 'desc'], true) ? $order[1] : 'asc';

        if (in_array($order[0], $this->fieldsOrder, true)) {
            $this->builder = $this->builder->orderBy($order[0], strtoupper($order[1]));
        }

        return $this->builder;
    }
}
