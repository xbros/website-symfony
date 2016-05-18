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

    public function simonMusicAction()
    {
        return $this->render('XbrosBundle:Default:simon-music.html.twig');
    }
}
