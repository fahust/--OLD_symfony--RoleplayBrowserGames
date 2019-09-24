<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonsterUserRepository")
 */
class MonsterUser
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
     * @ORM\Column(type="integer")
     */
    private $hp;

    /**
     * @ORM\Column(type="integer")
     */
    private $atk;

    /**
     * @ORM\Column(type="integer")
     */
    private $dgt;

    /**
     * @ORM\Column(type="integer")
     */
    private $esq;

    /**
     * @ORM\Column(type="integer")
     */
    private $def;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1,max = 100000)
     */
    private $maxhp;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1,max = 100)
     */
    private $maxatk;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1,max = 100)
     */
    private $maxesq;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1,max = 100)
     */
    private $maxdef;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1,max = 100)
     */
    private $maxdgt;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="monsterUsers")
     */
    private $skillbdd;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="monsterUsers")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cible;

    public function __construct()
    {
        $this->skillbdd = new ArrayCollection();
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

    public function getHp(): ?int
    {
        return $this->hp;
    }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    public function getAtk(): ?int
    {
        return $this->atk;
    }

    public function setAtk(int $atk): self
    {
        $this->atk = $atk;

        return $this;
    }

    public function getDgt(): ?int
    {
        return $this->dgt;
    }

    public function setDgt(int $dgt): self
    {
        $this->dgt = $dgt;

        return $this;
    }

    public function getEsq(): ?int
    {
        return $this->esq;
    }

    public function setEsq(int $esq): self
    {
        $this->esq = $esq;

        return $this;
    }

    public function getDef(): ?int
    {
        return $this->def;
    }

    public function setDef(int $def): self
    {
        $this->def = $def;

        return $this;
    }

    public function getMaxhp(): ?int
    {
        return $this->maxhp;
    }

    public function setMaxhp(int $maxhp): self
    {
        $this->maxhp = $maxhp;

        return $this;
    }

    public function getMaxatk(): ?int
    {
        return $this->maxatk;
    }

    public function setMaxatk(int $maxatk): self
    {
        $this->maxatk = $maxatk;

        return $this;
    }

    public function getMaxdef(): ?int
    {
        return $this->maxdef;
    }

    public function setMaxdef(int $maxdef): self
    {
        $this->maxdef = $maxdef;

        return $this;
    }

    public function getMaxesq(): ?int
    {
        return $this->maxesq;
    }

    public function setMaxesq(int $maxesq): self
    {
        $this->maxesq = $maxesq;

        return $this;
    }

    public function getMaxdgt(): ?int
    {
        return $this->maxdgt;
    }

    public function setMaxdgt(int $maxdgt): self
    {
        $this->maxdgt = $maxdgt;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkillbdd(): Collection
    {
        return $this->skillbdd;
    }

    public function addSkillbdd(Skill $skillbdd): self
    {
        if (!$this->skillbdd->contains($skillbdd)) {
            $this->skillbdd[] = $skillbdd;
        }

        return $this;
    }

    public function removeSkillbdd(Skill $skillbdd): self
    {
        if ($this->skillbdd->contains($skillbdd)) {
            $this->skillbdd->removeElement($skillbdd);
        }

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

    public function getCible(): ?int
    {
        return $this->cible;
    }

    public function setCible(?int $cible): self
    {
        $this->cible = $cible;

        return $this;
    }
}
