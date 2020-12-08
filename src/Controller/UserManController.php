<?php

namespace App\Controller;

use App\Entity\UserMan;
use App\Form\UserManType;
use App\Repository\UserManRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/man")
 */
class UserManController extends AbstractController
{
    /**
     * @Route("/", name="user_man_index", methods={"GET"})
     */
    public function index(UserManRepository $userManRepository): Response
    {
        return $this->render('user_man/index.html.twig', [
            'user_men' => $userManRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_man_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userMan = new UserMan();
        $form = $this->createForm(UserManType::class, $userMan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userMan);
            $entityManager->flush();

            return $this->redirectToRoute('user_man_index');
        }

        return $this->render('user_man/new.html.twig', [
            'user_man' => $userMan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_man_show", methods={"GET"})
     */
    public function show(UserMan $userMan): Response
    {
        return $this->render('user_man/show.html.twig', [
            'user_man' => $userMan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_man_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserMan $userMan): Response
    {
        $form = $this->createForm(UserManType::class, $userMan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_man_index');
        }

        return $this->render('user_man/edit.html.twig', [
            'user_man' => $userMan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_man_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserMan $userMan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userMan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userMan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_man_index');
    }
}
