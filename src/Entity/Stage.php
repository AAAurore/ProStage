<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\NotBlank(message = "Le titre doit être renseigné.")
     */
    private $titre;

    /**
     * @ORM\Column(type="text", length=1000, nullable=true)
     * @Assert\NotBlank(message = "La description doit être renseignée.")
     * @Assert\Length(
     *      min = 10,
     *      max = 1000,
     *      minMessage = "La description doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "La description doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message = "L'acivité doit être renseigné.")
     */
    private $activite;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="Stage", cascade={"persist"})
     */
    private $entreprise;  // Une seule entreprise pour un stage

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, mappedBy="Stage", cascade={"persist"})
     */
    private $formations;  // Une ou plusieurs formations pour un stage

    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(?string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(?\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->addStage($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            $formation->removeStage($this);
        }

        return $this;
    }
}
