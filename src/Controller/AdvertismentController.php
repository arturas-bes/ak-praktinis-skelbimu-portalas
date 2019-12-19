<?php

namespace App\Controller;

use App\Entity\Advertisment;
use App\Form\AdvertismentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Utilities\Uploader;

class AdvertismentController extends AbstractController
{
    /**
     * @Route("/profile/services/add_advertisment", name="add_adv")
     * @param Request $request
     * @param Uploader $uploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAdvertisment( Request $request, Uploader $uploader)
    {
        $blogPost = new Advertisment();

        $form = $this->createForm(AdvertismentType::class, $blogPost);

        if ($this->saveAdvertisment($blogPost, $form, $request, $uploader)) {

            return $this->redirectToRoute('active_services');

        }

        return $this->render('front/add_adv.html.twig',[
            'form' => $form->createView(),
            'advertisments' => $this->getAllAdvertisments()
        ]);
    }

    /**
     * @Route("/profile/services/edit-adv/{id}", name="edit_adv")
     * @param Advertisment $blogPost
     * @param Request $request
     * @param Uploader $uploader
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAdvertisment(Advertisment $blogPost, Request $request, Uploader $uploader)
    {
        $form = $this->createForm(AdvertismentType::class, $blogPost);

        if ($this->saveAdvertisment($blogPost, $form, $request, $uploader)) {

            return $this->redirectToRoute('add_adv');

        }
        return $this->render('front/edit_adv.html.twig',[

            'advertisment' => $blogPost,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/profile/services/delete-adv/{id}", name="delete_adv")
     * @param Advertisment $blogPost
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAdvertisment(Advertisment $blogPost)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($blogPost);
        $em->flush();

        return $this->redirectToRoute('add_adv');
    }

    /**
     * @param $blogPost
     * @param $form
     * @param $request
     * @param Uploader $uploader
     * @return bool
     */
    private function saveAdvertisment($blogPost, $form, $request, $uploader)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $blogPost->setTitle($request->request->get('advertisment')['title']);

            $blogPost->setSubject($request->request->get('advertisment')['subject']);
            $blogPost->setAuthor($this->getUser());
            $file = $blogPost->getUploadedImage();

            $this->saveImage($blogPost, $file, $uploader);

            $repo = $this->getDoctrine()->getRepository(Advertisment::class);

            $em = $this->getDoctrine()->getManager();

            $em->persist($blogPost);
            $em->flush();

            return true;
        }
        return false;
    }

    private function saveImage($blogPost, $file, $uploader)
    {
        $basePath = Advertisment::AdvertismentImagesUploadFolder;
        $fileName = $uploader->upload($file);

        $blogPost->setImagePath($basePath.$fileName[0]);
        $blogPost->setImageTitle($fileName[1]);
    }

    public function getAllAdvertisments()
    {
        $em = $this->getDoctrine()->getManager();
        $repo =  $em->getRepository(Advertisment::class);

        return $repo->findAll();
    }


}
