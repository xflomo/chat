<?php
namespace MainBundle\Controller;

use MainBundle\Entity\Chatroom;
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
                        echo $this->createNewChatroom();
                        break;
                    case "getMessagesFromChatroom":
                        echo $this->getMessagesFromChatroom();
                        break;
                }
            }
        }
        return $this->render('MainBundle:default:ajax.html.twig');
    }

    // Create new Chatroom
    public function createNewChatroom(){

        $repository = $this->getDoctrine()->getRepository('MainBundle:Chatroom');
        // TODO wenn user bereits chatraum hat dann diese id vergeben
        // Generate Chatroom ID
        do {
            $chatroomId = rand(0, 99999);
        } while ($repository->findOneBy( array('id' => $chatroomId)) !== null);

        // Create Chatroom Object
        $now = new \DateTime('NOW');
        $chatroom = new Chatroom();
        $chatroom->setId($chatroomId);
        $chatroom->setAdmin(1);
        $chatroom->setOwner(1);
        $chatroom->setCreatetime($now);

        $em = $this->getDoctrine()->getManager();

        $em->persist($chatroom);
        // Safe Chatroom in Database
        $em->flush();

        return $chatroomId;
    }

    public function getMessagesFromChatroom (){
        return $this->removeHeaderFromTwigTemplate($this->render('MainBundle:ajax:chatroom-message-content.html.twig'));
    }

    public function removeHeaderFromTwigTemplate($content){
        $content = str_replace("HTTP/1.0 200 OK","",$content);
        $content = str_replace("Cache-Control:","",$content);
        $content = str_replace("no-cache","",$content);
        return $content;
    }
}


