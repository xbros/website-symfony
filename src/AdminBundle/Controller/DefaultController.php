<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        $users = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AdminBundle:AdminUsers');

        if ($session->has('login')) {
            return new RedirectResponse($this->generateUrl('xbros_homepage'));
        } else {
            if ($request->isMethod('POST')) {
                $check_avail_login = count($user = $users->findByUsername($_POST['login']));

                if ($check_avail_login != 0) {
                    $user = $users->findOneByUsername($_POST['login']);

                    if ($user->getPassword() == $_POST['password']) {
                        $session->set('login', $_POST['login']);
                        $session->getFlashBag()->add('notice', 'Utilisateur connecté');
                    } else {
                        $session->getFlashBag()->add('notice', 'Utilisateur ou mot de passe incorrect');
                        return $this->render('AdminBundle:Default:login.html.twig');
                    }

                    //return new RedirectResponse($this->generateUrl('portfolio_homepage'));
                    return $this->redirect($this->generateUrl('xbros_homepage'));
                }
                else
                {
                    $session->getFlashBag()->add('notice', 'Utilisateur ou mot de passe incorrect');
                    return $this->render('AdminBundle:Default:login.html.twig');
                }

            } else {

                return $this->render('AdminBundle:Default:login.html.twig');

            }
        }
    }

    public function logoutAction(Request $request)
    {
        $session = $request->getSession();

        if ($session->has('login')) {
            $session->clear();
        }

        return $this->redirect($this->generateUrl('xbros_homepage'));
    }
}
