<?php
namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MainBundle\Entity\Files;
use MainBundle\Entity\User;

class FileRepository extends EntityRepository
{
    // Verschiebt die Datei in den Papierkorb
    public function removeFileToTrash($file)
    {
        $query = $this->getEntityManager()
            ->createQuery(
            'UPDATE MainBundle:Files f
            SET f.trash = 1
            WHERE f.hashName = :hashName
            AND f.owner = :owner'
        )->setParameters(array(
                'hashName' => $file->getHashName(),
                'owner' => $file->getOwner(),
            ));

        $query->execute();
    }

    // Stellt eine Datei aus dem Papierkorb wiederher
    public function restoreFile($file)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'UPDATE MainBundle:Files f
            SET f.trash = 0
            WHERE f.hashName = :hashName
            AND f.owner = :owner'
            )->setParameters(array(
                'hashName' => $file->getHashName(),
                'owner' => $file->getOwner(),
            ));

        $query->execute();
    }

    // Entfernt die Datei Komplett
    public function removeFile($file)
    {



        $userRepository = $this->getEntityManager()->getRepository(User::class);

        $user = $userRepository->loadUserByUserId($file->getOwner());

        $this->delTree($file->getUploadRootDir()."/".$user->getUsername()."/".$file->getHashName());

        $query = $this->getEntityManager()
            ->createQuery(
            'DELETE FROM MainBundle:Files f
            WHERE f.hashName = :hashName
            AND f.owner = :owner
            AND f.trash = 1'
            )->setParameters(array(
                'hashName' => $file->getHashName(),
                'owner' => $file->getOwner(),
            ));
        $query->execute();
    }

    // Holt sich die Bilder für die Übersichtsseite
    public function getUserFiles($userId)
    {
        $query = $this->getEntityManager()
            ->createQuery(
            'SELECT f
            FROM MainBundle:Files f
            WHERE f.owner = :userId
            AND f.trash = 0
            ORDER BY f.uploadTime DESC'
        )->setParameter('userId', $userId);

        return $query->getResult();
    }

    // Holt alle Bilder aus dem Papierkorb
    public function getUserTrash($userId)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT f
            FROM MainBundle:Files f
            WHERE f.owner = :userId
            AND f.trash = 1
            ORDER BY f.uploadTime DESC'
            )->setParameter('userId', $userId);

        return $query->getResult();
    }

    // Löschte Ordner Rekusive
    public function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}