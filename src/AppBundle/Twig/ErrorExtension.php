<?php
/*
 * @package AppBundle\Twig
 */

namespace AppBundle\Twig;

/**
 * Class GetUserImage
 * @package AppBundle\Twig
 */
class ErrorExtension extends \Twig_Extension {

    public function __construct()
    {

    }

    public function getFunctions()
    {
        return array(
            "getResponsibleName" => new \Twig_SimpleFunction('getResponsibleName', array($this, 'getResponsibleName')),
        );
    }

    public function getResponsibleName($vid)
    {
        $user = $this->UserManager->findUserBy(array('id'=>$vid));


        return $user->getNachname().', '.$user->getVorname();
    }
}