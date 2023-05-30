<?php

namespace Pebble\Security\RSA\Exceptions;


class PrivateKeyNotFoundException extends KeyNotFoundException
{

    public function __construct($filename = null, \Exception $previous = null) {

        parent::__construct('private', $filename, $previous);

    }

}