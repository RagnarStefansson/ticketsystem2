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
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $uid;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $freeform;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $times;

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
}
