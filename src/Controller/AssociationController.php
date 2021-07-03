<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AssociationController extends AbstractController
{

    /**
     * Todo
     * barre de recherche
     * Galerie photo
     * Rubrique Actualité de l'association
     * Bouton Catégories
     *
     */

    /**
     * @Route("/", name="index")
     */
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        $entreprises = $entrepriseRepository->findAll();
        $serializer = $this->get('serializer');
        $jsonEntreprises = $serializer->serialize($entreprises,'json'); //entrepriseList is serialized in order to be able to filter it by categorie

        return $this->render('association/index.html.twig', [
            'controller_name' => 'AssociationController',
            'entreprises' => $jsonEntreprises,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('association/contact.html.twig', [
            'controller_name' => 'AssociationController',
        ]);
    }

    /**
     * @Route("/association", name="association")
     */
    public function association(): Response
    {
        return $this->render('association/contact.html.twig', [
            'controller_name' => 'AssociationController',
        ]);
    }

}
