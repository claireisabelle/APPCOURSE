<?php

namespace AppcourseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppcourseBundle\Entity\Liste;
use AppcourseBundle\Entity\Produit;
use AppcourseBundle\Entity\Rayon;

use AppcourseBundle\Form\Type\RayonType;


class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('AppcourseBundle:liste:index.html.twig');
    }


    public function viewAction($id)
    {
    	// Permet de visualiser une liste de courses selon son $id

    	return $this->render('AppcourseBundle:index.html.twig');
    }

    public function addAction()
    {
    	// Permet d'ajouter une liste de courses
    }

    public function editAction($id)
    {
    	// Permet d'éditer une liste de courses
    }

    public function deleteAction($id)
    {
    	// Permet de supprimer une liste de courses
    }



    public function produitIndexAction()
    {
    	// Permet de visualiser l'ensemble des produits
    }

    public function produitAddAction()
    {
    	// Permet d'ajouter un produit 
    }

    public function produitEditAction($id)
    {
    	// Permet d'éditer un produit
    }

    public function produitDeleteAction($id)
    {
    	// Permet de supprimer un produit
    }



    public function rayonIndexAction()
    {
    	// Permet de visualiser l'ensemble des rayons

        $em = $this->getDoctrine()->getManager();

        $listRayons = $em->getRepository('AppcourseBundle:Rayon')->findBy(array(), array('nom' => 'ASC'));

        return $this->render('AppcourseBundle:rayon:index.html.twig', array('listRayons' => $listRayons));
    }

    public function rayonAddAction(Request $request)
    {
    	// Permet d'ajouter un rayon

        // On crée un nouveau rayon
        $rayon = new Rayon();

        // On appelle le formulaire créé dans RayonType
        $form = $this->createForm(RayonType::class, $rayon);
        $form->handleRequest($request);

        // Si le formulaire est valide, on l'enregistre
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rayon);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le rayon a bien été ajouté.');

            return $this->redirectToRoute('appcourse_index_rayon');
        }

        // Sinon, on renvoie vers la page de création avec la formulaire
        return $this->render('AppcourseBundle:rayon:add.html.twig', array('form' => $form->createView(),));
    }

    public function rayonEditAction($id)
    {
    	// Permet d'éditer un rayon
    }

    public function rayonDeleteAction($id)
    {
    	// Permet de supprimer un rayon
    }

}
