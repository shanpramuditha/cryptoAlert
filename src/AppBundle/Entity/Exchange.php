<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exchange
 *
 * @ORM\Table(name="exchange")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExchangeRepository")
 */
class Exchange
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="Symbol", mappedBy="exchange")
     */
    private $symbols;


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
     * Set name
     *
     * @param string $name
     * @return Exchange
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->exchange = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Add symbols
     *
     * @param \AppBundle\Entity\Symbol $symbols
     * @return Exchange
     */
    public function addSymbol(\AppBundle\Entity\Symbol $symbols)
    {
        $this->symbols[] = $symbols;

        return $this;
    }

    /**
     * Remove symbols
     *
     * @param \AppBundle\Entity\Symbol $symbols
     */
    public function removeSymbol(\AppBundle\Entity\Symbol $symbols)
    {
        $this->symbols->removeElement($symbols);
    }

    /**
     * Get symbols
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSymbols()
    {
        return $this->symbols;
    }
}
