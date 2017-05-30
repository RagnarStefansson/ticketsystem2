<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAllUsersOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM AppBundle:User u ORDER BY u.username ASC'
            )
            ->getResult();
    }

    public function isUsernameUnique($username)
    {
        $result = $this->getEntityManager()
            ->createQuery("select count(u) FROM AppBundle:User u WHERE u.username='".$username."'")
            ->getResult();

        if($result[0][1] > 0) {
            return false;
        }

        return true;
    }
}