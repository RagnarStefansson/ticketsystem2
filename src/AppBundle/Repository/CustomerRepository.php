<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository
{
    public function findAllCustomersOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c FROM AppBundle:Customer c ORDER BY c.name ASC'
            )
            ->getResult();
    }

    public function isCustomernameUnique($name)
    {
        $result = $this->getEntityManager()
            ->createQuery("select count(c) FROM AppBundle:Customer c WHERE c.name='".$name."'")
            ->getResult();

        if($result[0][1] > 0) {
            return false;
        }

        return true;
    }

    public function getContractName($vid) {
    return $this->getEntityManager()
        ->createQuery(
            'SELECT c.vname FROM AppBundle:Contract c WHERE c.vid=' . $vid
        )
        ->getResult();
}

    public function getCustomerName($kid) {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c.vname FROM AppBundle:Customer c WHERE c.kid=' . $kid
            )
            ->getResult();
    }

    public function getCustomerById($kid)
    {
        $result = $this->getEntityManager()
            ->createQuery(
                'SELECT c FROM AppBundle:Customer c WHERE c.kid=' . $kid
            )
            ->getResult();

        return $result;
    }
}