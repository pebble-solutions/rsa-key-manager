<?php

namespace Pebble\Security\RSA\Exceptions;

class ExpiredKeyException extends \Exception
{

    public function __construct(\Exception $previous = null) {

        $message = "La clé de déchiffrement de la signature est expirée.";

        parent::__construct($message, 401, $previous);

    }

}