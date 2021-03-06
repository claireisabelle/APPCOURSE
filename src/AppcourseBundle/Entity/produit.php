<?php

namespace AppcourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="cb_produit")
 * @ORM\Entity(repositoryClass="AppcourseBundle\Repository\ProduitRepository")
 * @ORM\HasLifecycleCallbacks()
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
    * @ORM\ManyToOne(targetEntity="Rayon", inversedBy="produits")
    * @Assert\NotBlank()
    */
    protected $rayon;

    /**
    * @ORM\ManyToMany(targetEntity="Liste", mappedBy="produits")
    */
    protected $listes;

    


    public function __construct()
    {
        $this->listes = new ArrayCollection;
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

    /**
     * Add liste
     *
     * @param \AppcourseBundle\Entity\Liste $liste
     *
     * @return Produit
     */
    public function addListe(\AppcourseBundle\Entity\Liste $liste)
    {
        $this->listes[] = $liste;

        return $this;
    }

    /**
     * Remove liste
     *
     * @param \AppcourseBundle\Entity\Liste $liste
     */
    public function removeListe(\AppcourseBundle\Entity\Liste $liste)
    {
        $this->listes->removeElement($liste);
    }

    /**
     * Get listes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListes()
    {
        return $this->listes;
    }


    /**
    * @ORM\PrePersist
    */
    public function increase()
    {
        $this->getRayon()->increaseProduit();
    }

    /**
    * @ORM\PreRemove
    */
    public function decrease()
    {
        $this->getRayon()->decreaseProduit();
    }
}
