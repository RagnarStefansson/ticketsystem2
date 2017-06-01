<?php
/*
 * @package AppBundle\Twig
 */

namespace AppBundle\Twig;

/**
 * Class GetUserImage
 * @package AppBundle\Twig
 */
class TicketExtension extends \Twig_Extension {
    private $em;
    private  $UserManager;

    public function __construct($em, $UserManager)
    {
        $this->em = $em;
        $this->UserManager = $UserManager;
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