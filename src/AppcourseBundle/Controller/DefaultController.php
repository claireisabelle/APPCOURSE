<?php

namespace AppcourseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('AppcourseBundle:listing:listing.html.twig');
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



    public function produitsIndexAction()
    {
    	// Permet de visualiser l'ensemble des produits
    }

    public function produitsAddAction()
    {
    	// Permet d'ajouter un produit 
    }

    public function produitsEditAction($id)
    {
    	// Permet d'éditer un produit
    }

    public function produitsDeleteAction($id)
    {
    	// Permet de supprimer un produit
    }



    public function rayonsIndexAction()
    {
    	// Permet de visualiser l'ensemble des rayons
    }

    public function rayonsAddAction()
    {
    	// Permet d'ajouter un rayon
    }

    public function rayonsEditAction($id)
    {
    	// Permet d'éditer un rayon
    }

    public function rayonsDeleteAction($id)
    {
    	// Permet de supprimer un rayon
    }

}
