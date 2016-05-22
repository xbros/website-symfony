<?php

namespace XbrosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('XbrosBundle:Default:index.html.twig');
    }

    public function resourcesAction()
    {
        return $this->render('XbrosBundle:Default:resources.html.twig');
    }

    public function codingRulesAction()
    {
        return $this->render('XbrosBundle:Default:coding-rules.html.twig');
    }

    public function todoAction()
    {
        return $this->render('XbrosBundle:Default:todo.html.twig');
    }

    public function systemAction()
    {
        return $this->render('XbrosBundle:Default:system.html.twig');
    }

    public function adrienAction()
    {
        return $this->render('XbrosBundle:Default:adrien.html.twig');
    }

    public function simonAction()
    {
        return $this->render('XbrosBundle:Default:simon.html.twig');
    }

    public function simonMusicAction($track)
    {
        $em = $this->getDoctrine()->getManager();

        if(isset($track))
        {
            $track_playing = $em
                ->getRepository('XbrosBundle:SimonMusic')
                ->findOneBy(
                    array('name' => $track)
                );
        }
        else
        {
            $track_playing = array();
        }

        $tracks = $em
            ->getRepository('XbrosBundle:SimonMusic')
            ->findBy(
                array(),    //where
                array('date' => 'DESC'
                )  //order
            );

        return $this->render('XbrosBundle:Default:simon-music.html.twig', array(
            'track_playing' => $track_playing,
            'tracks' => $tracks
        ));
    }

    public function projectRubikAction()
    {
        return $this->render('XbrosBundle:Default:project-rubik.html.twig');
    }
}
