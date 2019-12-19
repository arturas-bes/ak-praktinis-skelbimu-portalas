<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\UserService;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/admin/add-service", name="add_service")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addService(Request $request)
    {
        $service = new Service();

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $service->setName($request->request->get('service')['name']);

            $em = $this->getDoctrine()->getManager();

            $em->persist($service);
            $em->flush();
            return $this->redirectToRoute('add_service');
        }


        return $this->render('admin/add_service.html.twig',[
            'form' => $form->createView(),
            'services' => $this->getAllServices(),
            'userService' => $this->getAllUserServices()
        ]);
    }
    public function getAllUserServices()
    {
        $em = $this->getDoctrine()->getManager();
        $repo =  $em->getRepository(UserService::class);

        return $repo->findBy(['user' => $this->getUser()]);
    }

    public function getAllServices()
    {
        $em = $this->getDoctrine()->getManager();
        $repo =  $em->getRepository(Service::class);

        return $repo->findAll();
    }

    /**
     * @Route("/admin/edit-service/{id}", name="edit_service", requirements={"id":"\d+"})
     * @param Service $service
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editCategory(Service $service, Request $request)
    {

        $form = $this->createForm(ServiceType::class, $service);


        if ($this->saveService($service, $form, $request)) {

            return $this->redirectToRoute('add_service');
        }

        return $this->render('admin/edit_service.html.twig',[
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }
    private function saveService($service, $form, $request)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $service->setName($request->request->get('service')['name']);
            $repo = $this->getDoctrine()->getRepository(Service::class);

            $em = $this->getDoctrine()->getManager();
            $em->persist($service);
            $em->flush();

            return true;
        }
        return false;
    }
    /**
     * @Route("/admin/delete-service/{id}", name="delete_service", requirements={"id":"\d+"})
     * @param Service $service
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteService(Service $service)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($service);
        $em->flush();

        return $this->redirectToRoute('add_service');
    }
}
