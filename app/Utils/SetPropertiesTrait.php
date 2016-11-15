<?php

namespace CinemaHD\Utils;

trait SetPropertiesTrait
{
    /**
     * Find the name for a setter method
     *
     * @param  string $field_name
     * @return string
     */
    protected function setterName($field_name)
    {
        $camel       = str_replace(' ', '', ucwords(str_replace('_', ' ', $field_name)));
        $setter_name = 'set' . $camel;

        return $setter_name;
    }

    /**
     * Set property to object from an array
     *
     * @param array $request_data
     * @return self
     */
    public function setProperties(array $request_data)
    {
        foreach ($request_data as $field_name => $field_value) {
            $setter_name = $this->setterName($field_name);
            if (method_exists($this, $setter_name)) {
                $this->{$setter_name}($field_value);
            }
        }

        return $this;
    }
}
