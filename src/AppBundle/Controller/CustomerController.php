<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
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

class CustomerController extends Controller
{
    /**
     * @Route("/customer", name="customermanagement")
     */
    public function customerListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $customers = $em->getRepository('AppBundle:Customer')->findAllCustomersOrderedByName();

        return $this->render('customer/customermanagement.html.twig', [
            'customers' => $customers,
        ]);
    }

    /**
     * @Route("/customer/create", name="createcustomer")
     */
    public function createCustomer(Request $request)
    {


        $form = $this->createFormBuilder()
            //->setAction($this->generateUrl('createcustomer'))
            ->add('name', TextType::class, array(
                'required' => true,
                'label' => 'Kunde'
            ))
            ->add('street', TextType::class, array(
                'required' => true,
                'label' => 'Straße'
            ))
            ->add('number', TextType::class, array(
                'required' => true,
                'label' => 'Nummer'
            ))
            ->add('zipcode', TextType::class, array(
                'required' => true,
                'label' => 'PLZ'
            ))
            ->add('city', TextType::class, array(
                'required' => true,
                'label' => 'Ort'
            ))
            ->add('country', TextType::class, array(
                'required' => true,
                'label' => 'Land'
            ))
            ->add('phone', TextType::class, array(
                'required' => true,
                'label' => 'Telefon'
            ))
            ->add('email', EmailType::class, array(
                'required' => true,
                'label' => 'E-Mail Adresse'
            ))
            ->add('vid', ChoiceType::class, array(
                'label' => 'Vertragsart',
                'choices'  => array(
                    'freier Kunde' => 1,
                    'Kontingentskunde' => 2,
                    'Wartungsvertrag' => 3,
                ),
            ))
            ->add('kontingent', TextType::class, array(
                'required' => false,
                'label' => 'Kontingent'
            ))
            ->add('save', SubmitType::class, array('label' => 'Kunden Erstellen'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $newUserData = $form->getData();
            $em = $this->getDoctrine()->getManager();

            if($em->getRepository('AppBundle:Customer')->isCustomernameUnique($newUserData['email'])) {

                // Neues Customerobjekt instanziieren und mit Formulardaten befüllen
                $CustomerService = $this->get('app.customerservice');
                $customer = new Customer();
                $customer
                    ->setName($newUserData['name'])
                    ->setAdress($CustomerService->createAdressArray(
                        $newUserData['street'],
                        $newUserData['number'],
                        $newUserData['zipcode'],
                        $newUserData['city'],
                        $newUserData['country']
                    ))
                    ->setPhone($newUserData['phone'])
                    ->setMail($newUserData['email'])
                    ->setVId($newUserData['vid'])
                    ->setKontingent($newUserData['kontingent']);

                // CustomerObjekt in Datenbank speichern
                $em->persist($customer);
                $em->flush();

                $this->addFlash('success', 'Customer angelegt');
                return $this->redirectToRoute('customermanagement');
            }

            $this->addFlash('danger', 'Customer existiert bereits');

        }

        return $this->render('customer/createcustomer.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $kid
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/customer/{kid}", name="showCustomer")
     */
    public function showCustomerAction($kid) {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:Customer')->find($kid);

        $tickets = $em->getRepository('AppBundle:Tickets')->findBy(array(
            'kid' => $kid
        ), array(
            'tid' => 'DESC'
        ));

        return $this->render("customer/customerprofile.html.twig", array(
            'customer' => $customer,
            'tickets' => $tickets
        ));
    }

    /**
     * @param Request $request
     * @param $kid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/customer/edit/{kid}", name="customeredit")
     */
    public function editCustomer(Request $request, $kid)
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('AppBundle:Customer')->find($kid);

        $adress = $customer->getAdress();

        $form = $this->createFormBuilder()
            //->setAction($this->generateUrl('createcustomer'))
            ->add('name', TextType::class, array(
                'data' => $customer->getName(),
                'required' => true,
                'label' => 'Kunde'
            ))
            ->add('street', TextType::class, array(
                'required' => true,
                'data' => $adress['street'],
                'label' => 'Straße'
            ))
            ->add('number', TextType::class, array(
                'required' => true,
                'data' => $adress['number'],
                'label' => 'Nummer'
            ))
            ->add('zipcode', TextType::class, array(
                'required' => true,
                'data' => $adress['zipcode'],
                'label' => 'PLZ'
            ))
            ->add('city', TextType::class, array(
                'required' => true,
                'data' => $adress['city'],
                'label' => 'Ort'
            ))
            ->add('country', TextType::class, array(
                'required' => true,
                'data' => $adress['country'],
                'label' => 'Land'
            ))
            ->add('phone', TextType::class, array(
                'data' => $customer->getPhone(),
                'required' => true,
                'label' => 'Telefon'
            ))
            ->add('email', EmailType::class, array(
                'data' => $customer->getMail(),
                'required' => true,
                'label' => 'E-Mail Adresse'
            ))
            ->add('vid', ChoiceType::class, array(
                'data' => $customer->getVid(),
                'label' => 'Vertragsart',
                'choices'  => array(
                    'freier Kunde' => 1,
                    'Kontingentskunde' => 2,
                    'Wartungsvertrag' => 3,
                ),
            ))
            ->add('kontingent', TextType::class, array(
                'data' => $customer->getKontingent(),
                'required' => false,
                'label' => 'Kontingent'
            ))
            ->add('save', SubmitType::class, array('label' => 'Kunden ändern'))
            ->getForm();

        $form->handleRequest($request);
        //
        if($form->isSubmitted() && $form->isValid()) {
            //$customer = $form->getData();
            $data = $form->getData();
            $CustomerService = $this->get('app.customerservice');

            $customer
                ->setName($data['name'])
                ->setAdress($CustomerService->createAdressArray($data['street'], $data['number'], $data['zipcode'], $data['city'], $data['country']))
                ->setPhone($data['phone'])
                ->setMail($data['email'])
                ->setVid($data['vid'])
                ->setKontingent($data['kontingent']);

            // CustomerObjekt in Datenbank speichern
            $em->persist($customer);
            $em->flush();

            $this->addFlash('success', 'Kunde aktuelisiert');
            return $this->redirectToRoute('customermanagement');
        }

        return $this->render('customer/editcustomer.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
