<?php

namespace MainBundle\Controller;

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


        return $this->render('MainBundle:default:chatroom.html.twig', array(
            "roomNumber" => $roomId
        ));
    }


}
