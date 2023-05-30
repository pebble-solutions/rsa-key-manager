<?php

namespace Pebble\Security\RSA\Exceptions;

class KeyNotFoundException extends \Exception
{

    public function __construct($keyType = null, $filename = null, \Exception $previous = null) {

        $dict = [
            'public' => "déchiffrement publique",
            'private' => "chiffrement privé"
        ];

        $term = $dict[$keyType] ?? "chiffrement/déchiffrement";

        $message = "La clé de $term n'a pas été trouvée.";

        if ($filename) {
            $message .= " Vérifiez que le fichier \"$filename\" existe et qu'il est accessible.";
        }

        parent::__construct($message, 500, $previous);

    }

}