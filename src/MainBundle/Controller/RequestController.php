<?php
namespace MainBundle\Controller;

use MainBundle\Entity\Chatroom;
use MainBundle\Entity\Messages;
use MainBundle\HelperClasses\ChatHelper;
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

        //$this->getMessagesFromChatroom("56332");
        //$this->newChatMessage(htmlspecialchars("<!--[if gte mso 9]><xml> <o:OfficeDocumentSettings> <o:AllowPNG/> <o:PixelsPerInch>96</o:PixelsPerInch> </o:OfficeDocumentSettings> </xml><![endif]--> <!--[if gte mso 9]><xml> <w:WordDocument> <w:View>Normal</w:View> <w:Zoom>0</w:Zoom> <w:TrackMoves/> <w:TrackFormatting/> s"), 1);

        if ($request->isXMLHttpRequest()) {

            if($request->get("ajaxCall") != null){
                switch ($request->get("ajaxCall")) {
                    case "createNewChatroom":
                        echo $this->createNewChatroom();
                        break;
                    case "getMessagesFromChatroom":
                        echo $this->getMessagesFromChatroom($request->get("chatId"));
                        break;
                    case "newChatMessage":
                        $this->newChatMessage($request->get("value"), $request->get("chatId"));
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

    public function getMessagesFromChatroom ($chatroomId){

        // TODO Check einbauen ob user in chatroom exisitert
        $repository = $this->getDoctrine()->getRepository('MainBundle:Chatroom');
        $chatroom = $repository->findOneBy( array('id' => $chatroomId));

        // If chatroom dosent exist do nothing
        if($chatroom === null){return;}

        // TODO Type checking der nachrichten (Systemnachricht, Usernachricht, Infonachricht usw.)

        $repository = $this->getDoctrine()->getRepository('MainBundle:Messages');
        $messages = $repository->findBy( array('chatroom' => $chatroomId));
        echo $this->removeHeaderFromTwigTemplate(
            $this->render('MainBundle:ajax:chatroom-message-content.html.twig', array(
                "messages" => $messages,
                "userId" =>$_SESSION['user']['userid']
            ))
        );
    }

    public function newChatMessage($text, $chatroomId){
        $repository = $this->getDoctrine()->getRepository('MainBundle:Chatroom');
        $chatroom = $repository->findOneBy( array('id' => $chatroomId));

        $chatHelper = new ChatHelper();
        $text = $chatHelper->optimizeChatMessage($text);


        // If chatroom dosent exist do nothing
        if($chatroom === null){return;}
        // Create Chatroom Object
        $senderId = $_SESSION['user']['userid'];
        $now = new \DateTime('NOW');
        $message = new Messages();
        $message->setChatroom($chatroomId);
        $message->setMessage($text);
        $message->setCreatetime($now);
        $message->setSender($senderId);
        $message->setType(1);

        $em = $this->getDoctrine()->getManager();

        $em->persist($message);
        // Safe Chatroom in Database
        $em->flush();
    }

    public function removeHeaderFromTwigTemplate($content){
        $content = str_replace("HTTP/1.0 200 OK","",$content);
        $content = str_replace("Cache-Control:","",$content);
        $content = str_replace("no-cache","",$content);
        return $content;
    }
}


