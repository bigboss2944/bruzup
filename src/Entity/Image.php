<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="texteAccompagnement", type="string", length=255, nullable=true)
     */
    private $texteAccompagnement;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Entreprise::class,inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprises;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexteAccompagnement(): ?string
    {
        return $this->texteAccompagnement;
    }

    public function setTexteAccompagnement(?string $texteAccompagnement): self
    {
        $this->texteAccompagnement = $texteAccompagnement;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEntreprises(): ?Entreprise
    {
        return $this->entreprises;
    }

    public function setEntreprises(?Entreprise $entreprise): self
    {
        $this->entreprises = $entreprise;

        return $this;
    }
}
