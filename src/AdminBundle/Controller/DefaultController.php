<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\SimonMusic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AdminBundle\Form\SimonMusicType;


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

                    $username = $user->getUsername();
                    $salt = exec("cat /safety/salt.txt");

                    if ($user->getPassword() == md5($_POST['password'].$salt.$username.$salt.$username)) {
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
            $em = $this
                ->getDoctrine()
                ->getManager();

            $track = $em
                ->getRepository('AdminBundle:SimonMusic')
                ->findOneBy(array(
                    "name" => $track
                ));

            $fileMp3Old = $track->getPathMp3();
            $fileImgOld = $track->getPathImg();

            $form = $this->createForm(SimonMusicType::class, $track);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $track = $form->getData();

                $fileMp3 = $track->getPathMp3();
                $fileImg = $track->getPathImg();

                if (!is_null($fileMp3))
                {
                    if ($this->checkFileIsMp3($fileMp3->guessExtension()))
                    {
                        $fileMp3Name = $track->getDate()->format('Y-d-m').'_'.strtolower(str_replace(' ', '-', $track->getName())).'.mp3';

                        $fileMp3->move(
                            $this->getParameter('simon_music_directory'),
                            $fileMp3Name
                        );

                        $track->setPathMp3($fileMp3Name);
                    }
                    else
                    {
                        $session->getFlashBag()->add('error', 'mp3 file is not a supported format (mp3)');

                        return $this->render('AdminBundle:Default:edit-simon-music.html.twig', array(
                            'session' => $session->all(),
                            'form' => $form->createView(),
                        ));
                    }

                }
                else if ($fileMp3Old != '')
                {
                    $track->setPathMp3($fileMp3Old);
                }

                if (!is_null($fileImg))
                {
                    if ($this->checkFileIsImage($fileImg->guessExtension()))
                    {
                        $fileImgName = $track->getDate()->format('Y-d-m').'_'.strtolower(str_replace(' ', '-', $track->getName())).'.'.$fileImg->guessExtension();

                        $fileImg->move(
                            $this->getParameter('simon_music_directory'),
                            $fileImgName
                        );

                        $track->setPathImg($fileImgName);
                    }
                    else
                    {
                        $session->getFlashBag()->add('error', 'image file is not a supported format (jpg, jpeg, png)');

                        return $this->render('AdminBundle:Default:edit-simon-music.html.twig', array(
                            'session' => $session->all(),
                            'form' => $form->createView(),
                        ));
                    }

                }
                else if ($fileImgOld != '')
                {
                    $track->setPathImg($fileImgOld);
                }

                $em->persist($track);
                $em->flush();

                $session->getFlashBag()->add('notice', 'track was added');
                return $this->redirect($this->generateUrl('xbros_simonmusic'));
            }
            else
            {
                return $this->render('AdminBundle:Default:edit-simon-music.html.twig', array(
                    'session' => $session->all(),
                    'form' => $form->createView()
                ));
            }
        }
        return $this->redirect($this->generateUrl('xbros_homepage'));
    }

    public function addSimonMusicAction(Request $request)
    {
        $session = $request->getSession();

        if ($session->has('login'))
        {
            $track = new SimonMusic();
            $form = $this->createForm(SimonMusicType::class, $track);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $em = $this
                    ->getDoctrine()
                    ->getManager();

                $track = $form->getData();

                $fileMp3 = $track->getPathMp3();
                $fileImg = $track->getPathImg();

                if (!is_null($fileMp3))
                {
                    if ($this->checkFileIsMp3($fileMp3->guessExtension()))
                    {
                        $fileMp3Name = $track->getDate()->format('Y-d-m').'_'.strtolower(str_replace(' ', '-', $track->getName())).'.mp3';

                        $fileMp3->move(
                            $this->getParameter('simon_music_directory'),
                            $fileMp3Name
                        );

                        $track->setPathMp3($fileMp3Name);
                    }
                    else
                    {
                        $session->getFlashBag()->add('error', 'mp3 file is not a supported format (mp3)');

                        return $this->render('AdminBundle:Default:add-simon-music.html.twig', array(
                            'session' => $session->all(),
                            'form' => $form->createView(),
                        ));
                    }

                }

                if (!is_null($fileImg))
                {
                    if ($this->checkFileIsImage($fileImg->guessExtension()))
                    {
                        $fileImgName = $track->getDate()->format('Y-d-m').'_'.strtolower(str_replace(' ', '-', $track->getName())).'.'.$fileImg->guessExtension();

                        $fileImg->move(
                            $this->getParameter('simon_music_directory'),
                            $fileImgName
                        );

                        $track->setPathImg($fileImgName);
                    }
                    else
                    {
                        $session->getFlashBag()->add('error', 'image file is not a supported format (jpg, jpeg, png)');

                        return $this->render('AdminBundle:Default:add-simon-music.html.twig', array(
                            'session' => $session->all(),
                            'form' => $form->createView(),
                        ));
                    }

                }

                $em->persist($track);
                $em->flush();

                $session->getFlashBag()->add('notice', 'track was added');
                return $this->redirect($this->generateUrl('xbros_simonmusic'));
            }
            else
            {
                return $this->render('AdminBundle:Default:add-simon-music.html.twig', array(
                    'session' => $session->all(),
                    'form' => $form->createView()
                ));
            }
        }
            return $this->redirect($this->generateUrl('xbros_homepage'));
    }

    private function checkFileIsImage($imageExtension)
    {
        $acceptedExtensions = array('jpg', 'JPG', 'jpeg', 'JPEG','png', 'PNG');

        if (in_array($imageExtension, $acceptedExtensions))
            return true;
        else
            return false;
    }

    private function checkFileIsMp3($mp3Extension)
    {
        $acceptedExtensions = array('mp3', 'mpga');

        if (in_array(strtolower($mp3Extension), $acceptedExtensions))
            return true;
        else
            return false;
    }
}
