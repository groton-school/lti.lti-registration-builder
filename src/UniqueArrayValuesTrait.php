<?php

declare(strict_types=1);

namespace GrotonSchool\LTI\Registration;

trait UniqueArrayValuesTrait
{
    protected function addUnique(mixed $value, string $propertyName)
    {
        if ($this->$propertyName === null) {
            $this->$propertyName = [];
        }
        if (!in_array($value, $this->$propertyName)) {
            $this->$propertyName[] = $value;
        }
        return $this;
    }
}
