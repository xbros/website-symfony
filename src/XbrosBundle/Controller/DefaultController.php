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
}
