<?php

namespace AppcourseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use AppcourseBundle\Entity\Rayon;

use AppcourseBundle\Form\Type\RayonType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class RayonController extends Controller
{

       /**
    * @Security("has_role('ROLE_USER')")
    */
    public function rayonIndexAction()
    {
    	// Permet de visualiser l'ensemble des rayons

        $em = $this->getDoctrine()->getManager();

        $listRayons = $em->getRepository('AppcourseBundle:Rayon')->findBy(array(), array('nom' => 'ASC'));

        return $this->render('AppcourseBundle:rayon:index.html.twig', array('listRayons' => $listRayons));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
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

    /**
    * @Security("has_role('ROLE_USER')")
    */
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
            // Pas besoin de persister car Doctrine connait déjà le rayon
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Le rayon a bien été modifié.');

            return $this->redirectToRoute('appcourse_index_rayon');
        }

        // Sinon, on affiche la page d'édition pour procéder à la mise à jour
        return $this->render('AppcourseBundle:rayon:edit.html.twig', array('form' => $form->createView(), 'rayon' => $rayon));

    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
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
