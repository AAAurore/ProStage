<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message = "Le nom doit être renseigné.")
     * @Assert\Length(
     *      min = 4,
     *      max = 100,
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "Le nom doit faire au maximum {{ limit }} caractères."
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="text", length=255)
     * @Assert\NotBlank(message = "L'adresse doit être renseignée.")
     * @Assert\Regex(pattern="# [^0][0-9]{1,3} #", message="Le numéro de rue semble incorrect.")
     * @Assert\Regex(pattern="#rue|avenue|boulevard|impasse|allée|place|route|voie#", message="Le type de route/voie semble incorrect.")
     * @Assert\Regex(pattern="# [0-9]{5} #", message="Le code postal semble incorrect.")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message = "Le site doit être renseigné.")
     * @Assert\Url(message = "Le site est invalide.")
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     */
    private $Stage;  // Un ou plusieurs stages pour une entreprise

    public function __construct()
    {
        $this->Stage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStage(): Collection
    {
        return $this->Stage;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->Stage->contains($stage)) {
            $this->Stage[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->Stage->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
