<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table(name="entreprise")
 * @ORM\Entity
 */
class Entreprise
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id",type="integer", nullable=false)
     */
    private $id;

//    /**
//     * @var int
//     *
//     * @ORM\Column(name="idLogo", type="integer", nullable=true)
//     * @ORM\Id
//     * @ORM\GeneratedValue(strategy="NONE")
//     */
//    private $idlogo;

    

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rue", type="string", length=50, nullable=true)
     */
    private $rue;

    /**
     * @var string
     *
     * @ORM\Column(name="codePostal", type="string", length=50, nullable=false)
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=50, nullable=false)
     */
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="string", length=10, nullable=true)
     */
    private $telephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="siteWeb", type="string", length=50, nullable=true)
     */
    private $siteweb;

    /**
     * @var string
     *
     * @ORM\Column(name="longDescription", type="string", length=500, nullable=false)
     */
    private $longdescription;

    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="string", length=30, nullable=false)
     */
    private $shortdescription;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     *
     * @ORM\ManyToOne(targetEntity=User::class,inversedBy="entreprises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    /**
     *
     * @ORM\ManyToOne(targetEntity=Categorie::class,inversedBy="entreprises")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     *
     * @ORM\OneToMany(targetEntity=Image::class,mappedBy="entreprises",orphanRemoval=true, cascade={"persist"})
     * 
     */
    private $images;

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getPhotos(): ?int
    // {
    //     return $this->images;
    // }

    // public function setPhotos(?Image $image): self
    // {
    //     $this->image = $images;

    //     return $this;
    // }

    

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSiteweb(): ?string
    {
        return $this->siteweb;
    }

    public function setSiteweb(?string $siteweb): self
    {
        $this->siteweb = $siteweb;

        return $this;
    }

    public function getLongdescription(): ?string
    {
        return $this->longdescription;
    }

    public function setLongdescription(string $longdescription): self
    {
        $this->longdescription = $longdescription;

        return $this;
    }

    public function getShortdescription(): ?string
    {
        return $this->shortdescription;
    }

    public function setShortdescription(string $shortdescription): self
    {
        $this->shortdescription = $shortdescription;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if($this->images!=null){
            if (!in_array($image, $this->images)) {
                $this->images[] = $image;
                $image->setEntreprises($this);
            }
        }
        else{
            $this->images[] = $image;
            $image->setEntreprises($this);
        }
        

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getEntreprises() === $this) {
                $image->setEntreprises(null);
            }
        }

        return $this;
    }


}
