<?php
namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RequestController extends Controller
{
    /**
     * @Route("/ajax", name="ajax_request")
     */
    public function ajaxAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            if($request->get("ajaxCall") != null){
                switch ($request->get("ajaxCall")) {
                    case "createNewChatroom":
                        $this->createNewChatroom();
                        break;
                }
            }
        }
        return $this->render('MainBundle:default:default.html.twig');
    }

    // Create new Chatroom
    public function createNewChatroom(){

    }
}


