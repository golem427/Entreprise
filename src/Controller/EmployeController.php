<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


// Une fonction d'un Controller s'appellera une action.
//      * Le nom de cette action (cette fonction) commencera TOUJOURS 
//par un verbe.

class EmployeController extends AbstractController
{
    
// * La route = 1param: l'uri, 2param: le nom de la route, 3param: la méthode HTTP.

    /**
    * @Route("/ajouter-un-employe", name="employe_create", methods={"GET|POST"})
    */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        //on crée une variable de formulaire depuis le prototype
        $employe = new Employe();

        # Pour faire fonctionner le mécanisme d'auto hydratation d'objet de Symfony, vous devrez passez en 2eme argument votre objet $employe.
        # Mais également que tous les noms de vos champs dans le prototye de form (EmployeFormType) aient EXACTEMENT les mêmes noms que les propriétés de la Class à laquelle il est rattaché.

        $form = $this->createForm(EmployeFormType::class, $employe);

        # Pour que Symfony récupère les données des inputs du form, vous devrez handleRequest().

        $form->handleRequest($request);

        ///////////////////////////////////////////////// METHODE POST///////////////////////////
        if($form->isSubmitted() && $form->isValid()){
        // récupérer les données des inputs
        //    $employe->$form->get('salary')->getData();

        $entityManager->persist($employe);
        $entityManager->flush();
        return $this->redirectToRoute('default_home');
        }

        return $this->render("form/employe.html.twig", [
            "form_employe" => $form->createView()
        ]);
    }

    /**
    * @Route("/modifier-un-employe-{id}", name="employe_update", methods={"GET|POST"})
    */
    public function update(Employe $employe, Request $request, EntityManagerInterface $entityManager): Response
    {
            $form = $this->createForm(EmployeFormType::class, $employe)
            ->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $entityManager->persist($employe);
                $entityManager->flush();
                return $this->redirectToRoute('default_home');
                }
        
                return $this->render("form/employe.html.twig", [
                    'employe' => $employe,
                    'form_employe' => $form->createView()
                ]);
    }

    /**
    * @Route("/supprimer-un-employe-{id}", name="employe_delete", methods={"GET"})
    */
    public function delete(Employe $employe, Request $request, EntityManagerInterface $entityManager): RedirectResponse
    {
         
                $entityManager->remove($employe);
                $entityManager->flush();
                return $this->redirectToRoute('default_home');
                }
           
    }

