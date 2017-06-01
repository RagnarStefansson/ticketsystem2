<?php

namespace AppBundle\Twig;

/**
 * Class GetUserImage
 * @package AppBundle\Twig
 */
class CustomerExtension extends \Twig_Extension {
    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return array(
            "getContractName" => new \Twig_SimpleFunction('getContractName', array($this, 'getContractName')),
            "getCustomerName" => new \Twig_SimpleFunction('getCustomerName', array($this, 'getCustomerName')),

        );
    }

    public function getContractName($vid)
    {
        $result = $this->em->getRepository('AppBundle:Customer')->getContractName($vid);

        return $result[0]['vname'];
    }

    public function getCustomerName($kid)
    {
        $customer = $this->em->getRepository('AppBundle:Customer')->find($kid);

        return $customer->getName();
    }
}