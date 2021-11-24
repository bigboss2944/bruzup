<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Entreprise;
use App\Form\User1Type;
use App\Form\UserType;
use App\Form\EntrepriseType;
use App\Repository\UserRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{username}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{username}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, Entreprise $entreprise, EntrepriseRepository $repoEntreprise): Response
    {
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);
        $formEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
        $formEntreprise->handleRequest($request);
        $entreprise=$repoEntreprise->findBy(['user' => $user ]);

        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        if ($formEntreprise->isSubmitted() && $formEntreprise->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'entreprise' => $entreprise,
            'formUser' => $formUser->createView(),
            'formEntreprise' => $formEntreprise->createView(),
        ]);
    }

    /**
     * @Route("/{username}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getUsername(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

}
