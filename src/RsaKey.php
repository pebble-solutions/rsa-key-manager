<?php

namespace Pebble\Security\RSA;

use Pebble\Security\RSA\Exceptions\ExpiredKeyException;
use Pebble\Security\RSA\Exceptions\KeyNotFoundException;
use Pebble\Security\RSA\Exceptions\PrivateKeyNotFoundException;
use Pebble\Security\RSA\Exceptions\PublicKeyNotFoundException;
use Pebble\Security\RSA\Interfaces\RsaKeyInterface;

class RsaKey implements RsaKeyInterface {

    /**
     * Nom de la clé.
     * La clé doit exister dans /var/credentials/
     * Les clés doivent respecter la norme suivante :
     * - KEY_NAME.key pour la clé privée
     * - KEY_NAME.key.pub pour la clé public
     */
    public ?string $key = null;


    public function __construct(?string $key = null)
    {
        $this->key = $key;
    }

    /**
     * Lis et retourne la clé public de déchiffrement des tokens.
     * 
     * @param string $dir           Sous-dossier contenant la clé
     * @param int $expires          Temps d'expiration du fichier.
     * 
     * @throws PublicKeyNotFoundException
     * @throws ExpiredKeyException
     * 
     * @return string
     */
    public function getPublicKey(?string $dir = null, ?int $expires = null): string
    {
        $dir = $dir ? $dir.'/' : '';

        $filename = __DIR__.'/../../../../var/credentials/'.$dir.$this->key.'.key.pub';

        if ($expires) {
            $maxtime = filemtime($filename) + $expires;

            if ($maxtime > time()) {
                throw new ExpiredKeyException();
            }
        }

        try {
            $key = self::getKeyFileContent($filename);
        }
        catch (KeyNotFoundException $e) {
            throw new PublicKeyNotFoundException($this->key);
        }

        return $key;
    }

    /**
     * Lis et retourne la clé privée de chiffrement des tokens.
     * 
     * @throws PrivateKeyNotFoundException
     * 
     * @return string
     */
    public function getPrivateKey(): string
    {
        $filename = __DIR__.'/../../../../var/credentials/'.$this->key.'.key';

        try {
            $key = self::getKeyFileContent($filename);
        }
        catch (KeyNotFoundException $e) {
            throw new PrivateKeyNotFoundException($this->key);
        }

        return $key;
    }

    /**
     * Récupère le contenu d'un fichier de clé
     * 
     * @param string $keyFile           Le chemin d'accès au fichier
     * 
     * @throws KeyNotFoundException
     * 
     * @return string
     */
    private static function getKeyFileContent(string $keyFile): string
    {
        $file = fopen( $keyFile, "r" );

        if ( $file == false) {
            throw new KeyNotFoundException($keyFile);
        }

        $filesize = filesize( $keyFile );
        $key = fread( $file, $filesize );
        fclose( $file );

        return $key;
    }

}
