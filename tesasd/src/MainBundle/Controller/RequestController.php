<?php
namespace MainBundle\Controller;

use MainBundle\Entity\Files;
use MainBundle\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class RequestController extends Controller
{
    /**
     * @Route("/ajax", name="ajax_request")
     */
    public function ajaxAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            $userId = $this->getUser()->getId();
            if($request->get("ajaxCall") != null){
                switch ($request->get("ajaxCall")) {
                    case "removeFileToTrash":
                        $file = new Files();
                        $em = $this->getDoctrine()->getManager();
                        $fileRepository = $em->getRepository(Files::class);

                        $file->setHashName($request->get('imageHash'))
                            ->setOwner($this->getUser()->getId());
                        $fileRepository->removeFileToTrash($file);
                        break;

                    case "removeFile":
                        $file = new Files();
                        $em = $this->getDoctrine()->getManager();
                        $fileRepository = $em->getRepository(Files::class);

                        $file->setHashName($request->get('imageHash'))
                            ->setOwner($this->getUser()->getId());
                        $fileRepository->removeFile($file);
                        break;

                    case "restoreFile":
                        $file = new Files();
                        $em = $this->getDoctrine()->getManager();
                        $fileRepository = $em->getRepository(Files::class);

                        $file->setHashName($request->get('imageHash'))
                            ->setOwner($this->getUser()->getId());
                        $fileRepository->restoreFile($file);
                        break;
                }
            }
        }
        return $this->render('MainBundle:start:index.html.twig');
    }
}