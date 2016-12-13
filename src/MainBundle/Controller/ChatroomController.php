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
        return $this->render('MainBundle:default:chatroom.html.twig');
    }


}
