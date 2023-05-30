<?php

namespace Pebble\Security\RSA\Exceptions;

class PublicKeyNotFoundException extends KeyNotFoundException
{

    public function __construct($filename = null, \Exception $previous = null) {

        parent::__construct('public', $filename, $previous);

    }

}