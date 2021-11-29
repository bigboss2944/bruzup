<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\User;
use App\Entity\Image;
use App\Form\EntrepriseType;
use App\Repository\UserRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


/**
 * @Route("/entreprise")
 */
class EntrepriseController extends AbstractController
{
    /**
     * @Route("/", name="entreprise_index", methods={"GET"})
     */
    public function index(): Response
    {
        $entreprises = $this->getDoctrine()
            ->getRepository(Entreprise::class)
            ->findAll();

        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    /**
     * @Route("/{username}", name="list_entreprise_by_user", methods={"GET"})
     */
    public function listEntrepriseByUser(string $username,EntrepriseRepository $entrepriseRepo , UserRepository $userRepo): Response
    {
        $user = new User();

        $user = $userRepo->findOneBy(['username'=>$username]);
        $entreprises = $entrepriseRepo->findBy(['user'=>$user->getId()]);
        
        
        // $entreprises = $this->getDoctrine()
        //     ->getRepository(Entreprise::class)
        //     ->findBy(['user'=>$user->getId()]);

        return $this->render('entreprise/welcome.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    /**
     * @Route("/Categorie/{idCategorie}", name="list_entreprise_by_categorie", methods={"GET"})
     */
    public function listEntrepriseByCategorie(int $idCategorie): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getNom();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], $encoders);
        
        $entreprises = $this->getDoctrine()
            ->getRepository(Entreprise::class)
            ->findBy(['categorie'=>$idCategorie]);

            // $jsonContent = $serializer->serialize($entreprises, 'json');

            // return $this->json($entreprises);


        $jsonContent = $serializer->serialize($entreprises, 'json');

        return $this->json($jsonContent);
    }

    /**
     * @Route("/new/{username}", name="entreprise_new", methods={"GET","POST"})
     */
    public function new($username,Request $request, UserRepository $repoUser): Response
    {
        $entreprise = new Entreprise();
        $formEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
        $formEntreprise->handleRequest($request);
        
        if ($formEntreprise->isSubmitted() && $formEntreprise->isValid()) {
            $images = $formEntreprise->get('images')->getData();
            foreach ($images as $image) {
                # code...
                //Génération du nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //On copie le fichier dans le dossier Upload
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                
                //Stockage du nom de l'image dans la base de données
                $img = new Image();
                $img->setName($fichier);
                $entreprise->addImage($img);
                
            }

            $entreprise->setUser($repoUser->findOneBy(['username'=>$username]));


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('entreprise_index');

        }

        return $this->render('entreprise/new.html.twig', [
            'entreprise' => $entreprise,
            'formEntreprise' => $formEntreprise->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entreprise_show", methods={"GET"})
     */
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entreprise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entreprise $entreprise): Response
    {
        $formEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
        $formEntreprise->handleRequest($request);

        if ($formEntreprise->isSubmitted() && $formEntreprise->isValid()) {
            $images = $formEntreprise->get('images')->getData();
            foreach ($images as $image) {
                # code...
                //Génération du nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //On copie le fichier dans le dossier Upload
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                
                

                //Stockage du nom de l'image dans la base de données
                $img = new Image();
                $img->setName($fichier);
                $entreprise->addImage($img);
                
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entreprise_index');
        }

        return $this->render('entreprise/edit.html.twig', [
            'entreprise' => $entreprise,
            'formEntreprise' => $formEntreprise->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entreprise_delete", methods={"POST"})
     */
    public function delete(Request $request, Entreprise $entreprise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entreprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entreprise_index');
    }

    /**
     * @Route("/delete/image/{id}", name="entreprise_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Image $image, Request $request){
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
