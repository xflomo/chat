<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Files;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/fotos", name="user_home")
     */
    public function userHomeSite(Request $request)
    {
        $file = new Files();

        $em = $this->getDoctrine()->getManager();
        $fileRepository = $em->getRepository(Files::class);
        $userFiles =  $fileRepository->getUserFiles($this->getUser()->getId());

        if(isset($_GET['action'])){
            if($_GET['action'] == 'uploadFunction'){
                if (!empty($_FILES)) {
                    if(exif_imagetype ($_FILES['file']['tmp_name'])){

                        $hashedFilename = $file->getFileTmpNameHash($_FILES['file']['tmp_name']);
                        $file->setUrlPath($hashedFilename)
                            ->setOriginalName($_FILES['file']['name'])
                            ->setHashName($hashedFilename)
                            ->setTyp($_FILES['file']['type'])
                            ->setSize($_FILES['file']['size'])
                            ->setChangeTime(new \DateTime("now"))
                            ->setTrash(false)
                            ->setOwner($this->getUser()->getId())
                            ->setDownload(0)
                            ->setUploadTime(new \DateTime("now"));
                        if($file->uploadFile($_FILES['file']['tmp_name'], $this->getUser()->getUsername())){
                            $em = $this->getDoctrine()->getManager();

                            $em->persist($file);

                            $em->flush();
                        }else{
                            //TODO Errorhandling
                        }
                    }
                }
            }
        }

        return $this->render(
            'MainBundle:start:index.html.twig',
            array(
                'userFiles' => $userFiles,
            ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/papierkorb", name="user_trash")
     */
    public function userTrashSite(Request $request)
    {
        $file = new Files();

        $em = $this->getDoctrine()->getManager();
        $fileRepository = $em->getRepository(Files::class);
        $userFiles =  $fileRepository->getUserTrash($this->getUser()->getId());

        if(isset($_GET['action'])){
            if($_GET['action'] == 'uploadFunction'){
                if (!empty($_FILES)) {
                    if(exif_imagetype ($_FILES['file']['tmp_name'])){

                        $hashedFilename = $file->getFileTmpNameHash($_FILES['file']['tmp_name']);
                        $file->setUrlPath($hashedFilename)
                            ->setOriginalName($_FILES['file']['name'])
                            ->setHashName($hashedFilename)
                            ->setTyp($_FILES['file']['type'])
                            ->setSize($_FILES['file']['size'])
                            ->setChangeTime(new \DateTime("now"))
                            ->setTrash(false)
                            ->setOwner($this->getUser()->getId())
                            ->setDownload(0)
                            ->setUploadTime(new \DateTime("now"));
                        if($file->uploadFile($_FILES['file']['tmp_name'], $this->getUser()->getUsername())){
                            $em = $this->getDoctrine()->getManager();

                            $em->persist($file);

                            $em->flush();
                        }else{
                            //TODO Errorhandling
                        }
                    }
                }
            }
        }

        return $this->render(
            'MainBundle:start:papierkorb.html.twig',
            array(
                'userFiles' => $userFiles,
            ));
    }


}
