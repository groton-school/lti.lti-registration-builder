<?php

declare(strict_types=1);

namespace GrotonSchool\LTI\Registration;

trait ValidateUriTrait
{
    protected function validateUri(string $uri)
    {
        if (parse_url($uri)) {
            return true;
        }
        throw new RegistrationException("'$uri' is not a valid URI");
    }
}
