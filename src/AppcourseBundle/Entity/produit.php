<?php

namespace AppcourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="cb_produit")
 * @ORM\Entity(repositoryClass="AppcourseBundle\Repository\ProduitRepository")
 */
class Produit
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
    *@ORM\ManyToOne(targetEntity="Rayon", inversedBy="produits")
    */
    protected $rayon;


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
     * @return produit
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
     * Set rayon
     *
     * @param \AppcourseBundle\Entity\Rayon $rayon
     *
     * @return Produit
     */
    public function setRayon(\AppcourseBundle\Entity\Rayon $rayon = null)
    {
        $this->rayon = $rayon;

        return $this;
    }

    /**
     * Get rayon
     *
     * @return \AppcourseBundle\Entity\Rayon
     */
    public function getRayon()
    {
        return $this->rayon;
    }
}
