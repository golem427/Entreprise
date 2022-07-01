<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /** 
     * @Route("/", name="default_home")
     */
    public function home(EntityManagerInterface $entityManager): Response
   {
    $employes = $entityManager->getRepository(Employe::class)->findAll();

    return $this->render("default/home.html.twig", [
        # on passe le tableau (array $employes) à twig
        "employes" => $employes
    ]);

   }
}
