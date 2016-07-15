<?php

namespace XbrosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();

        return $this->render('XbrosBundle:Default:index.html.twig', array(
            'session' => $session->all(),
        ));
    }

    public function resourcesAction(Request $request)
    {
        $session = $request->getSession();

        return $this->render('XbrosBundle:Default:resources.html.twig', array(
            'session' => $session->all(),
        ));
    }

    public function codingRulesAction(Request $request)
    {
        $session = $request->getSession();

        return $this->render('XbrosBundle:Default:coding-rules.html.twig', array(
            'session' => $session->all(),
        ));
    }

    public function todoAction(Request $request)
    {
        $session = $request->getSession();

        return $this->render('XbrosBundle:Default:todo.html.twig', array(
            'session' => $session->all(),
        ));
    }

    public function systemAction(Request $request)
    {
        $session = $request->getSession();

        return $this->render('XbrosBundle:Default:system.html.twig', array(
            'session' => $session->all(),
        ));
    }

    public function adrienAction(Request $request)
    {
        $session = $request->getSession();

        return $this->render('XbrosBundle:Default:adrien.html.twig', array(
            'session' => $session->all(),
        ));
    }

    public function simonAction(Request $request)
    {
        $session = $request->getSession();

        return $this->render('XbrosBundle:Default:simon.html.twig', array(
            'session' => $session->all(),
        ));
    }

    public function simonMusicAction(Request $request, $track)
    {
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();
        # Doctrine: pour gerer la bdd en objet
        # em = entity manager: parle avec la bdd

        if(isset($track))
        {
            $track_playing = $em
                ->getRepository('AdminBundle:SimonMusic')
                ->findOneBy(
                    array('name' => $track)
                );
        }
        else
        {
            $track_playing = array();
        }

        $tracks = $em
            ->getRepository('AdminBundle:SimonMusic')
            ->findBy(
                array(),    //where
                array('date' => 'DESC'
                )  //order
            );

        return $this->render('XbrosBundle:Default:simon-music.html.twig', array(
            'session' => $session->all(),
            'track_playing' => $track_playing,
            'tracks' => $tracks
        ));
    }


    public function projectRubikAction(Request $request)
    {
        $session = $request->getSession();

        return $this->render('XbrosBundle:Default:project-rubik.html.twig', array(
            'session' => $session->all(),
        ));
    }
}
