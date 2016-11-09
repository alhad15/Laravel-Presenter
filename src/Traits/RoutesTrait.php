<?php

namespace BrianFaust\Presenter;

trait RoutesTrait
{
    /**
     * @var boolean
     */
    protected $appendEntityRouteKey = true;

    /**
     * @return string
     */
    public function indexRoute()
    {
        return $this->buildRoute('index');
    }

    /**
     * @return string
     */
    public function createRoute()
    {
        return $this->buildRoute('create');
    }

    /**
     * @return string
     */
    public function storeRoute()
    {
        return $this->buildRoute('store');
    }

    /**
     * @return string
     */
    public function showRoute()
    {
        return $this->buildRoute('show', true);
    }

    /**
     * @return string
     */
    public function editRoute()
    {
        return $this->buildRoute('edit', true);
    }

    /**
     * @return string
     */
    public function updateRoute()
    {
        return $this->buildRoute('update', true);
    }

    /**
     * @return string
     */
    public function deleteRoute()
    {
        return $this->buildRoute('delete', true);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->entity->getRouteKeyName();
    }

    /**
     * @return array
     */
    public function getRouteParameters()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getRoutePrefix()
    {
        return strtolower(str_plural(class_basename(get_class($this->entity))));
    }

    /**
     * @return array
     */
    public function routeNames()
    {
        $prefix = $this->getRoutePrefix();

        return [
            'index'  => $prefix.'.index',
            'create' => $prefix.'.create',
            'store'  => $prefix.'.store',
            'show'   => $prefix.'.show',
            'edit'   => $prefix.'.edit',
            'update' => $prefix.'.update',
            'delete' => $prefix.'.destroy',
        ];
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    private function routeName($key)
    {
        return $this->routeNames()[$key];
    }

    /**
     * @return string
     */
    private function buildRoute($name, $keyName = false)
    {
        $name = $this->routeName($name);

        return $keyName ? route($name, $this->buildRouteParameters()) : route($name);
    }

    /**
     * @return array
     */
    private function buildRouteParameters()
    {
        $entity = $this->entity->toArray();

        $parameters = [];
        foreach ($this->getRouteParameters() as $segment) {
            $parameters[] = array_get($entity, $segment);
        }

        if ($this->appendEntityRouteKey) {
            $parameters[] = array_get($entity, $this->getRouteKeyName());
        }

        return $parameters;
    }
}
