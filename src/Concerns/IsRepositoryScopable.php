<?php

namespace LaraChimp\MangoRepo\Concerns;

trait IsRepositoryScopable
{
    /**
     * Whenever a function is called we try to
     * scope it to the model.
     *
     * @param string $name
     * @param mixed  $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        // Get Model
        $model = $this->getModel();

        // Apply scope and get builder.
        $builder = call_user_func_array([$model, $name], $arguments);

        return $builder;
    }
}
