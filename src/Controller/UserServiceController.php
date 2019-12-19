<?php

namespace App\Controller;

use App\Entity\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserServiceController extends AbstractController
{
    /**
     * @Route("/profile/services", name="active_services")
     */
    public function index()
    {
       $services = $this->getDoctrine()
            ->getRepository(UserService::class)
            ->getActiveServices($this->getUser());
        return $this->render('front/active_services.html.twig', [
            'services' => $services
        ]);
    }
}
