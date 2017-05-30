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
 * @ORM\Table(name="trouble")
 */
class Trouble
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $pid;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $titel;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $tags;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kid;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $freeform;

    /**
     * Get pId
     *
     * @return integer
     */
    public function getPId()
    {
        return $this->pid;
    }

    /**
     * Set titel
     *
     * @param string $titel
     *
     * @return Trouble
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
     * Set tags
     *
     * @param array $tags
     *
     * @return Trouble
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set kId
     *
     * @param integer $kId
     *
     * @return Trouble
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
     * Set freeform
     *
     * @param string $freeform
     *
     * @return Trouble
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
}
