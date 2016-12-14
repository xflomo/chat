<?php

namespace MainBundle\Repository;


class TokenRepository extends EntityRepository
{
    public function getAll(){
        $query = $this->createQueryBuilder('t')
            ->getQuery();
        return $query->getArrayResult();
    }

    public function findOneByToken($token){
        return $this->createQueryBuilder('t')
            ->where('t.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
    }
}