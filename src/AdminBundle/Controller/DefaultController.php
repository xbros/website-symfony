<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\SimonMusic;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    public function addSimonMusicAction(Request $request)
    {
        $session = $request->getSession();

        if ($session->has('login'))
        {
//            if ($request->isMethod('POST'))
//            {
//
//                $em = $this->getDoctrine()->getManager();
//
//                $track = new SimonMusic();
//
//                $track->setName($_POST['name']);
//                $track->setDate(new \DateTime($_POST['date']));
//                if (!is_null($_POST['fileWav'])) {
//                    $track->setPathWav('simon-music/'.$_POST['fileWav']);
//                }
//                if (!is_null($_POST['fileMp3'])) {
//                    $track->setPathMp3('simon-music/'.$_POST['fileMp3']);
//                }
//                if (!is_null($_POST['fileImg'])) {
//                    $track->setPathImg('simon-music/'.$_POST['fileImg']);
//                }
//                if (!is_null($_POST['linkSite'])) {
//                    $track->setLinkSite($_POST['linkSite']);
//                }
//                if (!is_null($_POST['linkUrl'])) {
//                    $track->setLinkUrl($_POST['linkUrl']);
//                }
//
//
//
//            }
//            else
//            {
//                return $this->render('AdminBundle:Default:add-simon-music.html.twig', array(
//                    'session' => $session->all()
//                ));
//            }

            $em = $this->getDoctrine()->getManager();

            $track = new SimonMusic();

            $form = $this->createFormBuilder($track)
                ->add('name', TextType::class, array(
                    'required'    => true,
                    'label' => 'Track Name',
                    ))
                ->add('date', DateType::class, array(
                    'required'    => true,
                    'data' => new \DateTime('now'),
                    'label' => 'Date of publication',
                ))
                ->add('pathWav', FileType::class, array(
                    'required'    => false,
                    'label' => 'Path Wav',
                    'empty_data'  => null
                ))
                ->add('pathMp3', FileType::class, array(
                    'required'    => false,
                    'label' => 'Path Mp3',
                    'empty_data'  => null
                ))
                ->add('pathImg', FileType::class, array(
                    'required'    => false,
                    'label' => 'Path Image',
                    'empty_data'  => null
                ))
                ->add('linkSite', TextType::class, array(
                    'required'    => false,
                    'label' => 'Link Site',
                    'empty_data'  => null
                ))
                ->add('linkUrl', TextType::class, array(
                    'required'    => false,
                    'label' => 'Link Url',
                    'empty_data'  => null
                ))
                ->add('save', SubmitType::class, array('label' => 'Add Track'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $fileWav = $track->getPathWav();
                $fileMp3 = $track->getPathMp3();
                $fileImg = $track->getPathImg();

                if(!is_null($fileWav))
                {
                    $fileWavName = $track->getDate()->format('Y-d-m').'_'.strtolower(str_replace(' ', '-', $track->getName())).'.wav';

                    $fileWav->move(
                        $this->container->getParameter('simon_music_directory'),
                        $fileWavName
                    );

                    $track->setPathWav($fileWavName);
                }
                if(!is_null($fileMp3))
                {
                    $fileMp3Name = $track->getDate()->format('Y-d-m').'_'.strtolower(str_replace(' ', '-', $track->getName())).'.mp3';

                    $fileMp3->move(
                        $this->container->getParameter('simon_music_directory'),
                        $fileMp3Name
                    );

                    $track->setPathWav($fileMp3Name);
                }
                if(!is_null($fileImg))
                {
                    $fileImgName = $track->getDate()->format('Y-d-m').'_'.strtolower(str_replace(' ', '-', $track->getName())).'.jpg';

                    $fileImg->move(
                        $this->container->getParameter('simon_music_directory'),
                        $fileImgName
                    );

                    $track->setPathWav($fileImgName);
                }

                $em->persist($track);
                $em->flush();

                return new RedirectResponse($this->generateUrl('xbros_simonmusic', array('track' => $track->getName())));
            }

            return $this->render('AdminBundle:Default:add-simon-music.html.twig', array(
                'session' => $session->all(),
                'form' => $form->createView(),
            ));
        }
        else
        {
            return new RedirectResponse($this->generateUrl('xbros_simonmusic'));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\SimonMusic',
        ));
    }
}
