<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("wish/ajouter", name="ajouter")
     */
    public function ajouter(EntityManagerInterface $emi, Request $request): Response
    {
        $wish = new Wish(); // je crée une Entity "vide"
        // je créé mon formulaire (type de formulaire + entity)
        $formWish = $this->createForm(WishType::class, $wish);
        // associer le formulaire avec les données envoyées
        // hydrater $wish
        $formWish->handleRequest($request);

        if ($formWish->isSubmitted() && $formWish->isValid()) {

            $wish->setDateCreated(new \DateTime());
            $emi->persist($wish);
            $emi->flush();
            return $this->redirectToRoute('liste');
        }
        return $this->render('wish/ajouter.html.twig',
            ['formWish' => $formWish->createView()]);

        //$wish->setTitle('Que toute ma famille soit heureuse');
        //$wish->setDescription('Et arrive à me supporter');
        // $wish->setAuthor('Moi');
        //  $wish->setIsPublished(true);
        // $wish->setDateCreated(new \DateTime());
        //Persister
        // $emi->persist($wish);
        //Flush
        // $emi->flush();
        // return $this->json($wish); #}

    }

    /**
     * @Route("/wish/enlever/{id}", name="wish_enlever")
     */
    public function enlever(Wish $wish, EntityManagerInterface $em): Response
    {
        $em->remove($wish);
        $em->flush();
        return $this->redirectToRoute('liste');
    }

    /**
     * @Route("/liste", name="liste")
     */
    public function liste(WishRepository $repo): Response
    {

        $wishliste = $repo->findBy([], ["dateCreated" => "DESC"]);
        return $this->render("wish/list.html.twig", ['wishliste' => $wishliste]);
    }


}
