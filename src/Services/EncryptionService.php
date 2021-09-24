<?php

namespace Cancionistica\Services;

use Cancionistica\Apis\EncryptionApi;

class EncryptionService implements EncryptionApi
{
    /**
     * @inheritDoc
     */
    public function encrypt(string $passphrase, string $plain_text): bool|string
    {
        $salt = random_bytes(256);
        $iv = random_bytes(16);

        $iterations = 999;
        $key = hash_pbkdf2("sha512", $passphrase, $salt, $iterations, 64);

        $encrypted_data = openssl_encrypt($plain_text, 'aes-256-cbc', hex2bin($key), OPENSSL_RAW_DATA, $iv);

        $data = array("ciphertext" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "salt" => bin2hex($salt));
        return json_encode($data);
    }
}
