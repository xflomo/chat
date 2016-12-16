<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Userinchatroom;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;


class ChatroomController extends Controller
{
    /**
     * @Route("/chatroom/{roomId}", name="chatroomAction")
     */
    public function chatroomAction ($roomId)
    {
        $repository = $this->getDoctrine()->getRepository('MainBundle:Chatroom');
        $chatroom = $repository->findOneBy( array('id' => $roomId));

        // If chatroom dosent exist redirect to startpage
        if($chatroom === null){
            return $this->redirectToRoute('defaultAction');
        }


        //TODO gucken ob usersession vorhanden wenn nicht dann user in chatroom eintragen

        if(!isset($_SESSION['user']['userid'])){
            $_SESSION['user']['userid'] = rand(1, 9999);
        }

        $senderId = $_SESSION['user']['userid'];

        $repositoryUIC = $this->getDoctrine()->getRepository('MainBundle:Userinchatroom');
        $userinChatroom = $repositoryUIC->findOneBy(array('userid' => $senderId, 'chatroomid' => $roomId));
        $chatroomsFromUser = $repositoryUIC->findBy(array('userid' => $senderId));
        $usersInChatroom = $repositoryUIC->findBy(array('chatroomid' => $roomId));
        $countUsers = count($usersInChatroom);

        if($userinChatroom === null){

            $now = new \DateTime('NOW');
            $userInChatroomObj = new Userinchatroom();
            $userInChatroomObj->setUserid($senderId);
            $userInChatroomObj->setChatroomid($roomId);
            $userInChatroomObj->setJointime($now);

            $em = $this->getDoctrine()->getManager();

            $em->persist($userInChatroomObj);
            // Safe Chatroom in Database
            $em->flush();
        }


        /***********************************
         * Remove Chatroom if no users In
         **********************************/

        $this->removeChatroomIfEmpty();


        return $this->render('MainBundle:default:chatroom.html.twig', array(
            "roomNumber" => $roomId,
            "userChatrooms" => $chatroomsFromUser,
            "countUsers" => $countUsers
        ));
    }


    function removeChatroomIfEmpty(){
        $repository = $this->getDoctrine()->getRepository('MainBundle:Chatroom');
        $repositoryUIC = $this->getDoctrine()->getRepository('MainBundle:Userinchatroom');
        $repositoryMes = $this->getDoctrine()->getRepository('MainBundle:Messages');
        $em = $this->getDoctrine()->getManager();

        $chatrooms = $repository->findAll();

        if(!empty($chatrooms)){
            foreach ($chatrooms as $key => $chatroom){
                $userinChatroom = $repositoryUIC->findOneBy(array('chatroomid' => $chatroom->getId()));
                if($userinChatroom === null){
                    $messagesOfChatroom = $repositoryMes->findBy(array('chatroom' => $chatroom->getId()));
                    if(!empty($messagesOfChatroom)){
                        foreach ($messagesOfChatroom as $key => $message){
                            $em->remove($message);
                            $em->flush();
                        }
                    }
                    $em->remove($chatroom);
                    $em->flush();
                }
            }
        }
    }

}
