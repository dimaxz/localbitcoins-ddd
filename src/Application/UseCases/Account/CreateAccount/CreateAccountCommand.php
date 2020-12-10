<?php


namespace Application\UseCases\Account\CreateAccount;

/**
 * Class CreateAccountCommand
 * @package Application\UseCases\Account
 */
class CreateAccountCommand
{
    protected $login;
    protected $publicKey;
    protected $secretKey;

    /**
     * CreateAccountCommand constructor.
     * @param string $login
     * @param string $publicKey
     * @param string $secretKey
     */
    public function __construct(string $login, string $publicKey, string $secretKey)
    {
        $this->login = $login;
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

}