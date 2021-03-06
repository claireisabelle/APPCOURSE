<?php

namespace AppcourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Rayon
 *
 * @ORM\Table(name="cb_rayon")
 * @ORM\Entity(repositoryClass="AppcourseBundle\Repository\RayonRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Rayon
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;



    /**
    * @ORM\OneToMany(targetEntity="Produit", mappedBy="rayon")
    */
    protected $produits;

    /**
    * @ORM\Column(name="nb_produits", type="integer")
    */
    private $nbProduits = 0;


    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return rayon
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add produit
     *
     * @param \AppcourseBundle\Entity\Produit $produit
     *
     * @return Rayon
     */
    public function addProduit(\AppcourseBundle\Entity\Produit $produit)
    {
        $this->produits[] = $produit;

        return $this;
    }

    /**
     * Remove produit
     *
     * @param \AppcourseBundle\Entity\Produit $produit
     */
    public function removeProduit(\AppcourseBundle\Entity\Produit $produit)
    {
        $this->produits->removeElement($produit);
    }

    /**
     * Get produits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * Set nbProduits
     *
     * @param integer $nbProduits
     *
     * @return Rayon
     */
    public function setNbProduits($nbProduits)
    {
        $this->nbProduits = $nbProduits;

        return $this;
    }

    /**
     * Get nbProduits
     *
     * @return integer
     */
    public function getNbProduits()
    {
        return $this->nbProduits;
    }

    public function increaseProduit()
    {
        $this->nbProduits++;
    }

    public function decreaseProduit()
    {
     $this->nbProduits--;
    }
}
