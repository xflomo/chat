<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{

    /**
     * @Route("/", name="defaultAction")
     */
    public function defaultAction (Request $request)
    {
        return $this->render('MainBundle:default:default.html.twig');
    }


}
