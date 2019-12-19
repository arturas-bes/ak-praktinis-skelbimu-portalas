<?php

namespace App\Controller;

use App\Entity\PaymentMethod;
use App\Form\PaymentMethodType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentMethodController extends AbstractController
{
    /**
     * @Route("/admin/add-payment", name="add_payment")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addPayment(Request $request)
    {
        $payment = new PaymentMethod();

        $form = $this->createForm(PaymentMethodType::class, $payment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $payment->setName($request->request->get('payment_method')['name']);

            $em = $this->getDoctrine()->getManager();

            $em->persist($payment);
            $em->flush();

            return $this->redirectToRoute('add_payment');
        }


        return $this->render('admin/add_payment.html.twig',[
            'form' => $form->createView(),
            'payments' => $this->getAllPayments(),
        ]);
    }
    public function getAllPayments()
    {
        $em = $this->getDoctrine()->getManager();
        $repo =  $em->getRepository(PaymentMethod::class);

        return $repo->findAll();
    }

    /**
     * @Route("/admin/edit-payment/{id}", name="edit_payment", requirements={"id":"\d+"})
     * @param PaymentMethod $payment
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editPayment(PaymentMethod $payment, Request $request)
    {

        $form = $this->createForm(PaymentMethodType::class, $payment);


        if ($this->savePayment($payment, $form, $request)) {

            return $this->redirectToRoute('add_payment');
        }

        return $this->render('admin/edit_payment.html.twig',[
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }
    private function savePayment($payment, $form, $request)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $payment->setName($request->request->get('payment_method')['name']);
            $repo = $this->getDoctrine()->getRepository(PaymentMethod::class);

            $em = $this->getDoctrine()->getManager();
            $em->persist($payment);
            $em->flush();

            return true;
        }
        return false;
    }
    /**
     * @Route("/admin/delete-payment/{id}", name="delete_payment", requirements={"id":"\d+"})
     * @param Service $payment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletePayment(PaymentMethod $payment)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($payment);
        $em->flush();

        return $this->redirectToRoute('add_payment');
    }
}
