<?php

namespace Page;

class Credentials
{
    /** pass and login*/
    private const USER_CREDENTIALS = ['ivan.bolshakov@epicsoftwaredev.com', 'volvoman101'];

    public function getCredentials(): array
    {
        return $userCredentials = self::USER_CREDENTIALS;
    }
}