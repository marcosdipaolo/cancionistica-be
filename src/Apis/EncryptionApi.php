<?php

namespace Cancionistica\Apis;

use Exception;

interface EncryptionApi
{
    /**
     * @param string $passphrase
     * @param string $plain_text
     * @return bool|string
     * @throws Exception
     */
    public function encrypt(string $passphrase, string $plain_text): bool|string;
}
