<?php
/**
 * Created by PhpStorm.
 * User: J.Hauck
 * Date: 25.05.2017
 * Time: 15:08
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 * @ORM\Table(name="customer")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $kid;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $vid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kontingent;



    /**
     * Get kId
     *
     * @return integer
     */
    public function getKId()
    {
        return $this->kid;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Customer
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
     * Set adress
     *
     * @param array $adress
     *
     * @return Customer
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return array
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Customer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Customer
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set vId
     *
     * @param integer $vId
     *
     * @return Customer
     */
    public function setVId($vId)
    {
        $this->vid = $vId;

        return $this;
    }

    /**
     * Get vId
     *
     * @return integer
     */
    public function getVId()
    {
        return $this->vid;
    }

    /**
     * Set kontingent
     *
     * @param integer $kontingent
     *
     * @return Customer
     */
    public function setKontingent($kontingent)
    {
        $this->kontingent = $kontingent;

        return $this;
    }

    /**
     * Get kontingent
     *
     * @return integer
     */
    public function getKontingent()
    {
        return $this->kontingent;
    }
}
