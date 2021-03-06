<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurrencyData
 *
 * @ORM\Table(name="currency_data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CurrencyDataRepository")
 */
class CurrencyData
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="exchange", type="string", length=255)
     */
    private $exchange;

    /**
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255)
     */
    private $currency;

    /**
     * @var float
     *
     * @ORM\Column(name="last", type="float")
     */
    private $last;

    /**
     * @var float
     *
     * @ORM\Column(name="bid", type="float")
     */
    private $bid;

    /**
     * @var float
     *
     * @ORM\Column(name="ask", type="float")
     */
    private $ask;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set exchange
     *
     * @param string $exchange
     * @return CurrencyData
     */
    public function setExchange($exchange)
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * Get exchange
     *
     * @return string 
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return CurrencyData
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set last
     *
     * @param float $last
     * @return CurrencyData
     */
    public function setLast($last)
    {
        $this->last = $last;

        return $this;
    }

    /**
     * Get last
     *
     * @return float 
     */
    public function getLast()
    {
        return $this->last;
    }

    /**
     * Set bid
     *
     * @param float $bid
     * @return CurrencyData
     */
    public function setBid($bid)
    {
        $this->bid = $bid;

        return $this;
    }

    /**
     * Get bid
     *
     * @return float 
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * Set ask
     *
     * @param float $ask
     * @return CurrencyData
     */
    public function setAsk($ask)
    {
        $this->ask = $ask;

        return $this;
    }

    /**
     * Get ask
     *
     * @return float 
     */
    public function getAsk()
    {
        return $this->ask;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return CurrencyData
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime 
     */
    public function getDatetime()
    {
        return $this->datetime;
    }
}
