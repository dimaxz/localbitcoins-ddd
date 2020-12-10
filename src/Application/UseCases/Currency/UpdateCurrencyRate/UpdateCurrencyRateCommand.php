<?php


namespace Application\UseCases\Currency\UpdateCurrencyRate;

/**
 * Class UpdateCurrencyRateCommand
 * @package Application\UseCases\Currency\UpdateCurrencyRate
 */
class UpdateCurrencyRateCommand
{

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $target;

    /**
     * @var string
     */
    protected $measure;

    /**
     * UpdateCurrencyRateCommand constructor.
     * @param string $login
     * @param string $target
     * @param string $measure
     */
    public function __construct(string $login, string $target, string $measure)
    {
        $this->login = $login;
        $this->target = $target;
        $this->measure = $measure;
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
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function getMeasure(): string
    {
        return $this->measure;
    }

}