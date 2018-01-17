<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Symbol
 *
 * @ORM\Table(name="symbol")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SymbolRepository")
 */
class Symbol
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
     * @ORM\Column(name="symbol", type="string", length=255)
     */
    private $symbol;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="Currency")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     */
    private $currency;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="Exchange", inversedBy="symbols")
     * @ORM\JoinColumn(name="exchange_id", referencedColumnName="id")
     */
    private $exchange;


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
     * Set symbol
     *
     * @param string $symbol
     * @return Symbol
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string 
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set currency
     *
     * @param \AppBundle\Entity\Currency $currency
     * @return Symbol
     */
    public function setCurrency(\AppBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \AppBundle\Entity\Currency 
     */
    public function getCurrency()
    {
        return $this->currency;
    }



    /**
     * Set exchange
     *
     * @param \AppBundle\Entity\Exchange $exchange
     * @return Symbol
     */
    public function setExchange(\AppBundle\Entity\Exchange $exchange = null)
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * Get exchange
     *
     * @return \AppBundle\Entity\Exchange 
     */
    public function getExchange()
    {
        return $this->exchange;
    }
}
