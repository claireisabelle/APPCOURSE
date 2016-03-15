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
use AppcourseBundle\Form\Type\ProduitType;


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

        $em = $this->getDoctrine()->getManager();

        $listProduits = $em->getRepository('AppcourseBundle:Produit')->findBy(array(), array('nom' => 'ASC'));

        return $this->render('AppcourseBundle:produit:index.html.twig', array('listProduits' => $listProduits));
    }

    public function produitAddAction(Request $request)
    {
    	// Permet d'ajouter un produit 

        // On crée un nouveau produit
        $produit = new Produit();

        // On appelle le formulaire créé dans ProduitType
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        // Si le formulaire a été soumis et est valide, on l'enregistre
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le produit a bien été ajouté.');

            return $this->redirectToRoute('appcourse_index_produit');
        }

        // Sinon, on affiche la page avec le formulaire d'ajout
        return $this->render('AppcourseBundle:produit:add.html.twig', array('form' => $form->createView()));

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
        return $this->render('AppcourseBundle:rayon:add.html.twig', array('form' => $form->createView()));
    }

    public function rayonEditAction(Request $request, $id)
    {
    	// Permet d'éditer un rayon
        $em = $this->getDoctrine()->getManager();

        $rayon = $em->getRepository('AppcourseBundle:Rayon')->find($id);

        // Si le rayon n'existe pas, on crée un message d'erreur
        if (!$rayon)
        {
            throw $this->createNotFoundException('Le rayon n°'.$id.' est inconnu.');
        }

        $form = $this->createForm(RayonType::class, $rayon);
        $form->handleRequest($request);

        // Si le formulaire d'édition a bien été soumis et est valide, on enregistre la modification
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($rayon);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le rayon a bien été modifié.');

            return $this->redirectToRoute('appcourse_index_rayon');
        }

        // Sinon, on affiche la page d'édition pour procéder à la mise à jour
        return $this->render('AppcourseBundle:rayon:edit.html.twig', array('form' => $form->createView(), 'rayon' => $rayon));

    }

    public function rayonDeleteAction(Request $request, $id)
    {
    	// Permet de supprimer un rayon
        $em = $this->getDoctrine()->getManager();

        $rayon = $em->getRepository('AppcourseBundle:Rayon')->find($id);

        // Si le rayon n'existe pas, on crée un message d'erreur
        if(!$rayon)
        {
            throw $this->createNotFoundException('Le rayon n° '.$id.' est inconnu.');
        }

        // On crée un formulaire vide avec juste le token automatique
        $form = $this->createFormBuilder()->getForm();


        // Si la confirmation a bien été faite par le formulaire vide, on supprime le rayon
        if($form->handleRequest($request)->isValid())
        {
            $em->remove($rayon);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le rayon a bien été supprimé.');

            return $this->redirectToRoute('appcourse_index_rayon');
        }

        // Sinon, on affiche le formulaire vide de confirmation
        return $this->render('AppcourseBundle:rayon:delete.html.twig', array('form' => $form->createView(), 'rayon' => $rayon));
    }

}
