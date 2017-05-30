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
 * @ORM\Table(name="contract")
 */
class Contract
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $vid;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $vname;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $servicelevel;

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
     * Set vName
     *
     * @param string $vName
     *
     * @return Contract
     */
    public function setVName($vName)
    {
        $this->vname = $vName;

        return $this;
    }

    /**
     * Get vName
     *
     * @return string
     */
    public function getVName()
    {
        return $this->vname;
    }

    /**
     * Set servicelevel
     *
     * @param integer $servicelevel
     *
     * @return Contract
     */
    public function setServicelevel($servicelevel)
    {
        $this->servicelevel = $servicelevel;

        return $this;
    }

    /**
     * Get servicelevel
     *
     * @return integer
     */
    public function getServicelevel()
    {
        return $this->servicelevel;
    }
}
