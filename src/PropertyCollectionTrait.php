<?php

declare(strict_types=1);

namespace GrotonSchool\LTI\Registration;

trait PropertyCollectionTrait
{
    /**
     * @param string[] $propertyNames
     * @return array<string,mixed>
     */
    public function requiredProperties(array $propertyNames)
    {
        $json = [];
        foreach ($propertyNames as $jsonProperty => $phpProperty) {
            $propertyName = is_numeric($jsonProperty) ? $phpProperty : $jsonProperty;
            if ($this->$phpProperty === null) {
                print_r($this);
                throw new RegistrationException("`$propertyName` is a required property but has no value");
            }
            $json[$propertyName] = $this->$phpProperty;
        }
        return $json;
    }

    /**
     * @param string[] $propertyNames
     * @return array<string,mixed>
     */
    protected function optionalProperties(array $propertyNames): array
    {
        $json = [];
        foreach ($propertyNames as $jsonProperty => $phpProperty) {
            if ($this->$phpProperty !== null) {
                $json[is_numeric($jsonProperty) ? $phpProperty : $jsonProperty] = $this->$phpProperty;
            }
        }
        return $json;
    }
}
