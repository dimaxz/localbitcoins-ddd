<?php


namespace Infrastructure\Repositories;

use Repo\Concrete\AbstractCriteria;

class AccountCriteria extends AbstractCriteria
{
    /**
     * @var
     */
    protected $login;

    /**
     * @return AccountCriteria
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param string|null $login
     * @return AccountCriteria
     */
    public function setFilterByLogin(?string $login): AccountCriteria
    {
        $this->login = $login;
        return $this;
    }
}