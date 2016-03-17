<?php

namespace AppcourseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use AppcourseBundle\Entity\Liste;
use AppcourseBundle\Entity\Produit;
use AppcourseBundle\Entity\Rayon;

use AppcourseBundle\Form\Type\RayonType;
use AppcourseBundle\Form\Type\ProduitType;
use AppcourseBundle\Form\Type\ListeType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class DefaultController extends Controller
{

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getManager();

        $listes = $em->getRepository('AppcourseBundle:Liste')->findBy(array(), array('date' => 'DESC'));

        return $this->render('AppcourseBundle:liste:index.html.twig', array('listes' => $listes));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function viewAction(Request $request, $id)
    {
    	// Permet de visualiser une liste de courses selon son $id
        $em = $this->getDoctrine()->getManager();

        $liste = $em->getRepository('AppcourseBundle:Liste')->findListe($id);

        if(!$liste)
        {
            throw $this->createNotFoundException('La liste n° '.$id.' est inconnue.');
        }

        $rayons = $em->getRepository('AppcourseBundle:Rayon')->findRayons($id);


        return $this->render('AppcourseBundle:liste:view.html.twig', array('liste' => $liste, 'rayons' => $rayons));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction(Request $request)
    {
    	// Permet d'ajouter une liste de courses

        // On crée une nouvelle liste de courses
        $liste = new Liste();

        // On appelle le formulaire
        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        // Si le formulaire a bien été soumis, on enregistre la liste
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($liste);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'La liste a bien été enregistrée.');

            return $this->redirectToRoute('appcourse_homepage');
        }

        // Sinon, on renvoie vers la page du formulaire
        return $this->render('AppcourseBundle:liste:add.html.twig', array('form' => $form->createView()));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function editAction(Request $request, $id)
    {
    	// Permet d'éditer une liste de courses

        $em = $this->getDoctrine()->getManager();

        $liste = $em->getRepository('AppcourseBundle:Liste')->find($id);

        if(!$liste)
        {
            throw $this->createNotFoundException('La liste n° '.$id.' est inconnue.');
        }

        $form = $this->createForm(ListeType::class, $liste);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'La liste a bien été mise à jour.');

            return $this->redirect($this->generateUrl('appcourse_view_liste', array('id' => $liste->getId())));
        }

        return $this->render('AppcourseBundle:liste:edit.html.twig', array('liste' => $liste, 'form' => $form->createView()));

    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction(Request $request, $id)
    {
    	// Permet de supprimer une liste de courses

        $em = $this->getDoctrine()->getManager();

        $liste = $em->getRepository('AppcourseBundle:Liste')->find($id);

        if(!$liste)
        {
            throw $this->createNotFoundException('La liste n° '.$id.' est inconnue.');
        }

        $form = $this->createFormBuilder()->getForm();

        if($form->handleRequest($request)->isValid())
        {
            $em->remove($liste);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'La liste a bien été supprimée.');

            return $this->redirectToRoute('appcourse_homepage');
        }

        return $this->render('AppcourseBundle:liste:delete.html.twig', array('form' => $form->createView(), 'liste' => $liste));
    }


    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function produitIndexAction()
    {
    	// Permet de visualiser l'ensemble des produits

        $em = $this->getDoctrine()->getManager();

        $listProduits = $em->getRepository('AppcourseBundle:Produit')->findBy(array(), array('nom' => 'ASC'));

        return $this->render('AppcourseBundle:produit:index.html.twig', array('listProduits' => $listProduits));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
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

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function produitEditAction(Request $request, $id)
    {
    	// Permet d'éditer un produit

        $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('AppcourseBundle:Produit')->find($id);

        // Si le produit n'existe pas, on crée un message d'erreur
        if(!$produit)
        {
            throw $this->createNotFoundException('Le produit n° '.$id.' est inconnu.');
        }

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        // Si le formulaire a bien été soumis et est valide, on enregistre la modification
        if($form->isSubmitted() && $form->isValid())
        {
            // Pas besoin de persister car Doctrine connait déjà le produit
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le produit a bien été mis à jour.');

            return $this->redirectToRoute('appcourse_index_produit');
        }

        // Sinon, on affiche le formulaire d'édition
        return $this->render('AppcourseBundle:produit:edit.html.twig', array('form' => $form->createView(), 'produit' => $produit));

    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function produitDeleteAction(Request $request, $id)
    {
    	// Permet de supprimer un produit

        $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('AppcourseBundle:Produit')->find($id);

        if(!$produit)
        {
            throw $this->createNotFoundException('Le produit n° '.$id.' est inconnu.');
        }

        // On crée un formulaire vide avec juste le token automatique
        $form = $this->createFormBuilder()->getForm();

        // Si la confirmation a bien été faite par le formulaire vide, on supprime le produit
        if($form->handleRequest($request)->isValid())
        {
            $em->remove($produit);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le produit a bien été supprimé.');

            return $this->redirectToRoute('appcourse_index_produit');
        }

        // Sinon on affiche la page de confirmation
        return $this->render('AppcourseBundle:produit:delete.html.twig', array('form' => $form->createView(), 'produit' => $produit));
    }


}
