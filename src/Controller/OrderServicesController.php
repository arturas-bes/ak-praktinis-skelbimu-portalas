<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\PaymentMethod;
use App\Entity\Service;
use App\Entity\UserService;
use App\Form\PaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Twig_SimpleFunction;

class OrderServicesController extends AbstractController
{
    /**
     * @Route("/order/services", name="order_services")
     */
    public function index(Request $request)
    {

        $payment = new Payment();
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $payment->setUser($user);

            $paymentMethod = $em->getRepository(PaymentMethod::class)
                ->find($request->request->get('payment')['paymentMethod']);
            $payment->setPaymentMethod($paymentMethod);

            $services = $request->request->get('payment')['service'];
            $date = new \DateTime();
            $count = 0;
            foreach ($services as $service) {
                $count++;
                $userService = new UserService();
                $userService->setUser($user);
                $userService->setIsActive(true);
                $userService->setService($em->getRepository(Service::class)->find($service));
                $userService->setServiceStartDate($date);
                $em->persist($userService);
            }
            $em->flush();
            $userServices = $em->getRepository(UserService::class)->getLastIds($count);
            $payment->setUserServices($userServices);
            $em->persist($payment);
            $em->flush();
            return $this->redirectToRoute('order_confirmation');
        }


        return $this->render('front/order_services.html.twig', [
            'services' => $this->findAllServices(),
            'payments' => $this->findAllPaymentMethods(),
            'userService' => $this->getAllUserServices(),
            'form' => $form->createView(),
        ]);
    }

public
function getAllUserServices()
{
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository(UserService::class);
    $result = $repo->findBy(['user' => $this->getUser(), 'isActive' => true]);
    $res = array();
    foreach ($result as $item)
        $res [] = $item->getService()->getId();

    return $res;
}

private
function checkForActiveServices($userService)
{
    if ($userService == true && $userService->getIsActive() == true) {

        return true;
    }
    return false;
}

/**
 * @return object[]
 */
private
function findAllServices()
{
    $em = $this->getDoctrine()->getManager();
    return $em->getRepository(Service::class)->findAll();
}

/**
 * @return object[]
 */
private
function findAllPaymentMethods()
{
    $em = $this->getDoctrine()->getManager();

    return $em->getRepository(PaymentMethod::class)->findAll();
}

/**
 * @Route("/order/confirmation", name="order_confirmation")
 */
public
function orderConfirmation()
{
    $em = $this->getDoctrine();
    $payment = $em->getRepository(Payment::class)->getLastPayment();

    $userServices = $em->
    getRepository(UserService::class)
        ->getOrderedServices($payment->getUserServices());

    return $this->render('front/order_confirmation.html.twig', [
        'payments' => $payment,
        'services' => $userServices,
    ]);
}

}
