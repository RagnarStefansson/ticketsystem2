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
 * @ORM\Entity
 * @ORM\Table(name="Tickets")
 */
class Tickets
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $tid;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $kid;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $titel;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $uid;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $freeform;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $times;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $status;




    /**
     * Get tId
     *
     * @return integer
     */
    public function getTId()
    {
        return $this->tid;
    }

    /**
     * Set kId
     *
     * @param integer $kId
     *
     * @return Tickets
     */
    public function setKId($kId)
    {
        $this->kid = $kId;

        return $this;
    }

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
     * Set status
     *
     * @param string $status
     *
     * @return Tickets
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set uId
     *
     * @param integer $uId
     *
     * @return Tickets
     */
    public function setUId($uId)
    {
        $this->uid = $uId;

        return $this;
    }

    /**
     * Get uId
     *
     * @return integer
     */
    public function getUId()
    {
        return $this->uid;
    }

    /**
     * Set freeform
     *
     * @param string $freeform
     *
     * @return Tickets
     */
    public function setFreeform($freeform)
    {
        $this->freeform = $freeform;

        return $this;
    }

    /**
     * Get freeform
     *
     * @return string
     */
    public function getFreeform()
    {
        return $this->freeform;
    }

    /**
     * Set times
     *
     * @param integer $times
     *
     * @return Tickets
     */
    public function setTimes($times)
    {
        $this->times = $times;

        return $this;
    }

    /**
     * Get times
     *
     * @return integer
     */
    public function getTimes()
    {
        return $this->times;
    }

    /**
     * Set titel
     *
     * @param string $titel
     *
     * @return Tickets
     */
    public function setTitel($titel)
    {
        $this->titel = $titel;

        return $this;
    }

    /**
     * Get titel
     *
     * @return string
     */
    public function getTitel()
    {
        return $this->titel;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Tickets
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Tickets
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
     * Set email
     *
     * @param string $email
     *
     * @return Tickets
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
