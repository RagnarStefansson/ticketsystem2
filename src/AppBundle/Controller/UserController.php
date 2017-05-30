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

class UserController extends Controller
{
    /**
     * @Route("/user", name="usermanagement")
     */
    public function userListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAllUsersOrderedByName();

        return $this->render('user/usermanagement.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @param $userid
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user/{userid}", name="showProfile")
     */
    public function showUserAction($userid) {
        $usermanager = $this->get('fos_user.user_manager');
        $user = $usermanager->findUserBy(array('id'=>$userid));

        return $this->render("user/userprofile.html.twig", array(
            'user' => $user
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/user/edit", name="usereditself")
     */
    public function editUserSelf(Request $request)
    {
        $user = $this->getUser();
        $user2 = $this->getUser();

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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/user/changepassword", name="changePasswordSelf")
     */
    public function changePasswordSelfAction(Request $request) {
        $user = $this->getUser();

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
            $usermanager = $this->get('fos_user.user_manager');
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
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
}
