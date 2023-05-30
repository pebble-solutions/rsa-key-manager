<?php

namespace Pebble\Security\RSA\Interfaces;

interface RsaKeyInterface {

    /**
     * Lis et retourne la clé public de déchiffrement
     * 
     * @param string $dir           Sous-dossier contenant la clé dans /var/credentials
     * @param int $expires          Temps d'expiration du fichier.
     * 
     * @throws PublicKeyNotFoundException
     * 
     * @return string
     */
    public function getPublicKey(?string $dir, ?int $expires): string;

    /**
     * Lis et retourne la clé privée de chiffrement
     * 
     * @throws PrivateKeyNotFoundException
     * 
     * @return string
     */
    public function getPrivateKey(): string;

}