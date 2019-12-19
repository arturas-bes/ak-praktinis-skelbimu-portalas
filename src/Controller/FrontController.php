<?php

namespace App\Controller;

use App\Entity\Advertisment;
use App\Entity\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
    {
        return $this->render('front/index.html.twig', [
            'userServices'  => $this->checkIsUserHasActiveServices(),
        ]);
    }
    public function checkIsUserHasActiveServices()
    {
        $userService = $this->getDoctrine()->getManager()->getRepository(UserService::class);
        $userService->findBy(['user' => $this->getUser()]);
        foreach ($userService as $item) {
            if ($item == 1) {
                return true;
            }
            return false;
        }
    }

    /**
     * @Route("/advertisments", name="advertisments")
     * @return Response
     */
    public function advertisments()
    {
        $em = $this->getDoctrine()->getManager();
        $advertisments =  $em->getRepository(Advertisment::class)->findAll();

        return $this->render('front/advertisments.html.twig', [
            'advertisments' => $advertisments,
        ]);
    }

    /**
     * @Route("/advertisment/{adv}", name="single_adv")
     * @param $adv
     * @return Response
     */
    public function getSingleAdv($adv)
    {   $em = $this->getDoctrine()->getManager();
        $singleAdv =  $em->getRepository(Advertisment::class)->find($adv);

        return $this->render('front/single_adv.html.twig',[
            'adv' => $singleAdv
        ]);
    }

    /**
     * @Route("/about", name="about_admin")
     */
    public function aboutAdminPage()
    {
        return $this->render('front/about_admin.html.twig',[

        ]);
    }
}