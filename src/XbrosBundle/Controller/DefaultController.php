<?php

namespace XbrosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('XbrosBundle:Default:index.html.twig');
    }
}
