<?php
/**
 * Created by PhpStorm.
 * User: J.Hauck
 * Date: 25.05.2017
 * Time: 15:08
 */

namespace AppBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $vorname;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nachname;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    /**
     * Set vorname
     *
     * @return string
     */
    public function setName()
    {
        return $this->vorname;
    }

    /**
     * Get vorname
     *
     * @return string
     */
    public function getName()
    {
        return $this->vorname;
    }

    /**
     * Set vorname
     *
     * @param string $vorname
     *
     * @return User
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;

        return $this;
    }


    /**
     * Get vorname
     *
     * @return string
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * Set nachname
     *
     * @param string $nachname
     *
     * @return User
     */
    public function setNachname($nachname)
    {
        $this->nachname = $nachname;

        return $this;
    }

    /**
     * Get nachname
     *
     * @return string
     */
    public function getNachname()
    {
        return $this->nachname;
    }

    public function isAdmin() {
        if(in_array('ROLE_ADMIN' ,$this->roles)) {
            return true;
        }
        return false;
    }
}
