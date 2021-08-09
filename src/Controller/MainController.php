<?php

namespace App\Controller;

use App\Repository\PersonneRepository;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="accueil")
     */
    public function accueil(): Response
    {
        //$route = new Route
        return $this->render("main/home.html.twig");
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render("main/contact.html.twig");
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render("main/about.html.twig");
    }

    /**
     * @Route("/liste", name="liste")
     */
    public function liste(WishRepository $repo): Response
    {

        $wishliste = $repo->findBy([], ["dateCreated" => "DESC"]);
        return $this->render("wish/list.html.twig", ['wishliste' => $wishliste]);
    }

    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(): Response
    {
        return $this->render("wish/ajouter.html.twig");
    }


}
