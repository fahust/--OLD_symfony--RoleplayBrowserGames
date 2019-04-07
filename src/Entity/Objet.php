<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjetRepository")
 */
class Objet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\QuestVariable", mappedBy="objetreussite")
     */
    private $questVariables;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="objet")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuestVariable", mappedBy="questrequismany")
     */
    private $questvariablesrequismany;

    /**
     * @ORM\Column(type="integer")
     */
    private $createur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    

    

    

    public function __construct()
    {
        $this->questVariables = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->questvariablesrequismany = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|QuestVariable[]
     */
    public function getQuestVariables(): Collection
    {
        return $this->questVariables;
    }

    public function addQuestVariable(QuestVariable $questVariable): self
    {
        if (!$this->questVariables->contains($questVariable)) {
            $this->questVariables[] = $questVariable;
            $questVariable->addObjetreussite($this);
        }

        return $this;
    }

    public function removeQuestVariable(QuestVariable $questVariable): self
    {
        if ($this->questVariables->contains($questVariable)) {
            $this->questVariables->removeElement($questVariable);
            $questVariable->removeObjetreussite($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addObjet($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeObjet($this);
        }

        return $this;
    }

    /**
     * @return Collection|QuestVariable[]
     */
    public function getQuestvariablesrequismany(): Collection
    {
        return $this->questvariablesrequismany;
    }

    public function addQuestvariablesrequismany(QuestVariable $questvariablesrequismany): self
    {
        if (!$this->questvariablesrequismany->contains($questvariablesrequismany)) {
            $this->questvariablesrequismany[] = $questvariablesrequismany;
            $questvariablesrequismany->setQuestrequismany($this);
        }

        return $this;
    }

    public function removeQuestvariablesrequismany(QuestVariable $questvariablesrequismany): self
    {
        if ($this->questvariablesrequismany->contains($questvariablesrequismany)) {
            $this->questvariablesrequismany->removeElement($questvariablesrequismany);
            // set the owning side to null (unless already changed)
            if ($questvariablesrequismany->getQuestrequismany() === $this) {
                $questvariablesrequismany->setQuestrequismany(null);
            }
        }

        return $this;
    }

    public function getCreateur(): ?int
    {
        return $this->createur;
    }

    public function setCreateur(int $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    

    

    
}
