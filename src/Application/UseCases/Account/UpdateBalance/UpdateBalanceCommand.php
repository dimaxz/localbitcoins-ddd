<?php


namespace Application\UseCases\Account\UpdateBalance;

class UpdateBalanceCommand
{
    /**
     * @var string
     */
    protected $login;

    /**
     * UpdateBalanceCommand constructor.
     * @param string $login
     */
    public function __construct(string $login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

}