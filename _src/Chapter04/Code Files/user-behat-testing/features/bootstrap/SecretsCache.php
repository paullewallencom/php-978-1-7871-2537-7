<?php

final class SecretsCache
{
    private $secretsMap = array();

    public function setSecret($secret)
    {
        $this->secretsMap[$secret] = $secret;
    }

    public function getSecret($secret)
    {
        return $this->secretsMap[$secret];
    }
}