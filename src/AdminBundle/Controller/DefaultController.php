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


    public function editSimonMusicAction(Request $request, $track)
    {
        $session = $request->getSession();

        if ($session->has('login'))
        {
            $em = $this->getDoctrine()->getManager();

            $track = $em
                ->getRepository('AdminBundle:SimonMusic')
                ->findOneBy(
                    array('name' => $track)
                );

            if ($request->isMethod('POST')) {
                $track->setName($_POST['name']);
                if (is_null($_POST['date'])) {
                    $track->setDate(null);
                }
                else {
                    $track->setDate(new \DateTime($_POST['date']));
                }
                if (is_null($_POST['pathWav'])) {
                    $track->setPathWav(null);
                }
                else {
                    $track->setPathWav($_POST['pathWav']);
                }
                if (is_null($_POST['pathMp3'])) {
                    $track->setPathMp3(null);
                }
                else {
                    $track->setPathMp3($_POST['pathMp3']);
                }
                if (is_null($_POST['pathImg'])) {
                    $track->setPathImg(null);
                }
                else {
                    $track->setPathImg($_POST['pathImg']);
                }
                if (is_null($_POST['linkSite'])) {
                    $track->setLinkSite(null);
                }
                else {
                    $track->setLinkSite($_POST['linkSite']);
                }
                if (is_null($_POST['linkUrl'])) {
                    $track->setLinkUrl(null);
                }
                else {
                    $track->setLinkUrl((string)$_POST['linkUrl']);
                }

                $em->persist($track);

                $em->flush();

                $session->getFlashBag()->add('notice', 'Track ' . $_POST['name'] . ' modifiée');

                return new RedirectResponse($this->generateUrl('xbros_simonmusic', array(
                    'track' => $_POST['name'],
                )));
            }
            else {
                return $this->render('AdminBundle:Default:edit-simon-music.html.twig', array(
                    'session' => $session->all(),
                    'track' => $track
                ));
            }
        }
        else
        {
            return new RedirectResponse($this->generateUrl('xbros_simonmusic'));
        }
    }
}
