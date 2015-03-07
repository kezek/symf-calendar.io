<?php

namespace Main\BaseBundle\Entity;

/**
 * @author Andrei Mocanu
 */
trait DataSetterTrait
{
    /**
     * Generic data setter .
     * Setter call has priority over property assigment
     * @param array $data
     * @return static
     */
    public function dataSetter(array $data)
    {
        foreach ($data as $key => $value) {
            $methodName = "set" . ucfirst($key);
            if (method_exists($this, $methodName)) {
                call_user_func_array(array($this, $methodName), array($value));
            } else if (array_key_exists($key, get_class_vars(get_class($this)))) {
                $this->$key = $value;
            }
        }

        return $this;
    }
}