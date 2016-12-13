<?php
namespace MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/", name="login")
     */
    public function loginAction(Request $request)
    {
        if(!empty($this->getUser())){
            $username = $this->getUser()->getUsername();
            return $this->redirectToRoute('user_home');
        }else{
            $authenticationUtils = $this->get('security.authentication_utils');

            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render(
                'MainBundle:user:login.html.twig',
                array(
                    // last username entered by the user
                    'last_username' => $lastUsername,
                    'error'         => $error,
                )
            );
        }
    }


    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {

        $this->get('security.token_storage')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        return $this->render(
            'MainBundle:user:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => "",
                'error'         => "",
            )
        );

    }
}