<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
     * @Route("/user/create", name="createuser")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function createUser(Request $request)
    {
        $form = $this->createFormBuilder()
            //->setAction($this->generateUrl('createuser'))
            ->add('vorname', TextType::class, array(
                'required' => true,
                'label' => 'Vorname'
            ))
            ->add('nachname', TextType::class, array(
                'required' => true,
                'label' => 'Nachname'
            ))
            ->add('email', EmailType::class, array(
                'required' => true,
                'label' => 'E-Mail Adresse'
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Die Passwörter müssen übereinstimmen',
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Password wiederholen')
            ))
            ->add('roleadmin', ChoiceType::class, array(
                'label' => 'Rolle',
                'choices'  => array(
                    'Admin' => true,
                    'User' => false,
                ),
            ))
            ->add('save', SubmitType::class, array('label' => 'Nutzer Erstellen'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $newUserData = $form->getData();

            $em = $this->getDoctrine()->getManager();
            if($em->getRepository('AppBundle:User')->isUsernameUnique($newUserData['email'])) {

                // Neues Userobjekt instanziieren und mit Formulardaten befüllen
                $user = new User();
                $user
                    ->setVorname($newUserData['vorname'])
                    ->setNachname($newUserData['nachname'])
                    ->setUsername($newUserData['email'])
                    ->setEmail($newUserData['email'])
                    ->setPlainPassword($newUserData['password'])
                    ->setEnabled(true);

                if($newUserData['roleadmin']) {
                    $user->addRole('ROLE_ADMIN');
                }

                // UserObjekt in Datenbank speichern
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'User angelegt');
                return $this->redirectToRoute('usermanagement');
            }

            $this->addFlash('danger', 'User existiert bereits');

        }

        return $this->render('user/createuser.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param $userid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/user/edit/{userid}", name="useredit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editUser(Request $request, $userid)
    {
        $usermanager = $this->get('fos_user.user_manager');
        $user = $usermanager->findUserBy(array('id'=>$userid));
        $user2 = $usermanager->findUserBy(array('id'=>$userid));

        $form = $this->createFormBuilder($user)
            ->add('id', HiddenType::class, array(
                'mapped' => false
            ))
            ->add('vorname', TextType::class, array(
                'required' => true,
                'label' => 'Vorname'
            ))
            ->add('nachname', TextType::class, array(
                'required' => true,
                'label' => 'Nachname'
            ))
            ->add('email', TextType::class, array(
                'required' => true,
                'label' => 'E-Mail Adresse'
            ))

            ->add('save', SubmitType::class, array('label' => 'Daten ändern'))
            ->getForm();

        $form->handleRequest($request);
        //

        if($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            if ($em->getRepository('AppBundle:User')->isUsernameUnique($user->getEmail()) || $user->getEmail() == $user2->getUsername()) {

                $user->setUsername($user->getEmail());
                // UserObjekt in Datenbank speichern
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'User aktuelisiert');
                return $this->redirectToRoute('usermanagement');
            }

            $this->addFlash('danger', 'Adresse existiert bereits');

        }

        return $this->render('user/edituser.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param $userid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/user/changepassword/{userid}", name="changePassword")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function changePasswordAction(Request $request, $userid) {
        $usermanager = $this->get('fos_user.user_manager');
        $user = $usermanager->findUserBy(array('id'=>$userid));

        $form = $this->createFormBuilder($user)
            ->add('id', HiddenType::class, array(
                'mapped' => false
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Die Passwörter müssen übereinstimmen',
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Password wiederholen')
            ))

            ->add('save', SubmitType::class, array('label' => 'Passwort ändern'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            //$user->setPlainPassword($user->getPassword());
            // UserObjekt in Datenbank speichern
            $usermanager->updatePassword($user);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Passwort geändert');
            return $this->redirectToRoute('usermanagement');
        }
        return $this->render('user/edituser.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $userid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/user/activation/{userid}", name="changeUserActivation")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function activateUserAction($userid) {
        $usermanager = $this->get('fos_user.user_manager');
        $user = $usermanager->findUserBy(array('id'=>$userid));

        if($user->isEnabled()) {
            $user->setEnabled(false);
        } else {
            $user->setEnabled(true);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute("showProfile", array('userid' => $userid));
    }
}
