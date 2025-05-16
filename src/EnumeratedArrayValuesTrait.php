<?php

declare(strict_types=1);

namespace GrotonSchool\LTI\Registration;

trait EnumeratedArrayValuesTrait
{
    /**
     * @param string $value
     * @param string[] $values
     */
    public function validateEnumeratedValues(string $value, array $values)
    {
        if (in_array($value, $values)) {
            return true;
        }
        throw new RegistrationException("'$value' is not a valid value (choose one of " . join(", ", array_map(fn ($v) => "'$v'", $values)) . ".");
    }
}
