<?php
namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MainBundle\Entity\Chatroom;

class ChatroomRepository extends EntityRepository
{

    public function generateUniqueId(){
        return rand(0, 99999);
    }

    //Suche nach Mitarbeitereinträgen
    public function getTeamByUrl($url)
    {
        return $this->createQueryBuilder('t')
            ->where('t.url = :url')
            ->setParameter('url', $url)
            ->getQuery()
            ->getOneOrNullResult();
    }


    public function getTeamByName($name)
    {
        return $this->createQueryBuilder('t')
            ->where('t.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getTeamById($id)
    {
        return $this->createQueryBuilder('t')
            ->where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getAllTeams(){
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function removeTeam($teamId){
        $query = $this->getEntityManager()->createQuery(
            'Delete
        FROM MainBundle:Team t
        WHERE t.id = '.$teamId
        );
        $query->getOneOrNullResult();
    }

    public function addNewTeam($teamData, $owner, $userRepository){
        $teamData = explode( '&', $teamData );
        foreach($teamData as $key => $value){
            $teamData[$key] = explode( '=', $value );
        }
        $teamName = ($teamData[0][1]);
        unset($teamData[0]);

        if(strlen($teamName <= 30))
        {
            if($this->getTeamByName($teamName) === null){

                $urlValidater = new UrlValidater();
                $url = $urlValidater->validateUrl($teamName);
                $team = new Team();
                $team->setName($teamName);
                $team->setUrl($url);
                $team->setOwnerId($owner);
                $team->setCreateDate(new \DateTime('NOW'));
                $em = $this->getEntityManager();
                $em->persist($team);
                $em->flush();

                $result = $this->getTeamByName($teamName);
                foreach($teamData as $key => $value){
                    if($userRepository->getUserById($value[1]) != null){
                        $membersInTeam = new UsersInTeams();
                        $membersInTeam->setTeamId($result->getId());
                        $membersInTeam->setUserId($value[1]);
                        $em->persist($membersInTeam);
                        $em->flush();
                        return true;
                    }

                }
            }
        }
        echo "false";
    }

}