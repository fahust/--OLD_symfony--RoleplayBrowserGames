<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 */
class Skill
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $skdgt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $skmana;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $skatk;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $skesq;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $skdef;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $skhp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dialsc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $manasc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $atksc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dgtsc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $esqsc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $defsc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hpsc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dialec;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dgtec;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $manaec;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $atkec;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $esqec;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $defec;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hpec;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Player", mappedBy="skillbdd")
     */
    private $players;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Monster", mappedBy="skillbdd")
     */
    private $monsters;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MonsterUser", mappedBy="skillbdd")
     */
    private $monsterUsers;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $createur;

    

    

    

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->monsters = new ArrayCollection();
        $this->monsterUsers = new ArrayCollection();
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

    public function getSkdgt(): ?string
    {
        return $this->skdgt;
    }

    public function setSkdgt(string $skdgt): self
    {
        $this->skdgt = $skdgt;

        return $this;
    }

    public function getSkmana(): ?string
    {
        return $this->skmana;
    }

    public function setSkmana(string $skmana): self
    {
        $this->skmana = $skmana;

        return $this;
    }

    public function getSkatk(): ?string
    {
        return $this->skatk;
    }

    public function setSkatk(string $skatk): self
    {
        $this->skatk = $skatk;

        return $this;
    }

    public function getSkesq(): ?string
    {
        return $this->skesq;
    }

    public function setSkesq(string $skesq): self
    {
        $this->skesq = $skesq;

        return $this;
    }

    public function getSkdef(): ?string
    {
        return $this->skdef;
    }

    public function setSkdef(string $skdef): self
    {
        $this->skdef = $skdef;

        return $this;
    }

    public function getSkhp(): ?string
    {
        return $this->skhp;
    }

    public function setSkhp(string $skhp): self
    {
        $this->skhp = $skhp;

        return $this;
    }

    public function getDialsc(): ?string
    {
        return $this->dialsc;
    }

    public function setDialsc(string $dialsc): self
    {
        $this->dialsc = $dialsc;

        return $this;
    }

    public function getManasc(): ?string
    {
        return $this->manasc;
    }

    public function setManasc(string $manasc): self
    {
        $this->manasc = $manasc;

        return $this;
    }

    public function getAtksc(): ?string
    {
        return $this->atksc;
    }

    public function setAtksc(string $atksc): self
    {
        $this->atksc = $atksc;

        return $this;
    }

    public function getDgtsc(): ?string
    {
        return $this->dgtsc;
    }

    public function setDgtsc(string $dgtsc): self
    {
        $this->dgtsc = $dgtsc;

        return $this;
    }

    public function getEsqsc(): ?string
    {
        return $this->esqsc;
    }

    public function setEsqsc(string $esqsc): self
    {
        $this->esqsc = $esqsc;

        return $this;
    }

    public function getDefsc(): ?string
    {
        return $this->defsc;
    }

    public function setDefsc(string $defsc): self
    {
        $this->defsc = $defsc;

        return $this;
    }

    public function getHpsc(): ?string
    {
        return $this->hpsc;
    }

    public function setHpsc(string $hpsc): self
    {
        $this->hpsc = $hpsc;

        return $this;
    }

    public function getDialec(): ?string
    {
        return $this->dialec;
    }

    public function setDialec(string $dialec): self
    {
        $this->dialec = $dialec;

        return $this;
    }

    public function getDgtec(): ?string
    {
        return $this->dgtec;
    }

    public function setDgtec(string $dgtec): self
    {
        $this->dgtec = $dgtec;

        return $this;
    }

    public function getManaec(): ?string
    {
        return $this->manaec;
    }

    public function setManaec(string $manaec): self
    {
        $this->manaec = $manaec;

        return $this;
    }

    public function getAtkec(): ?string
    {
        return $this->atkec;
    }

    public function setAtkec(string $atkec): self
    {
        $this->atkec = $atkec;

        return $this;
    }

    public function getEsqec(): ?string
    {
        return $this->esqec;
    }

    public function setEsqec(string $esqec): self
    {
        $this->esqec = $esqec;

        return $this;
    }

    public function getDefec(): ?string
    {
        return $this->defec;
    }

    public function setDefec(string $defec): self
    {
        $this->defec = $defec;

        return $this;
    }

    public function getHpec(): ?string
    {
        return $this->hpec;
    }

    public function setHpec(string $hpec): self
    {
        $this->hpec = $hpec;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->addSkillbdd($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            $player->removeSkillbdd($this);
        }

        return $this;
    }

    /**
     * @return Collection|Monster[]
     */
    public function getMonsters(): Collection
    {
        return $this->monsters;
    }

    public function addMonster(Monster $monster): self
    {
        if (!$this->monsters->contains($monster)) {
            $this->monsters[] = $monster;
            $monster->addSkillbdd($this);
        }

        return $this;
    }

    public function removeMonster(Monster $monster): self
    {
        if ($this->monsters->contains($monster)) {
            $this->monsters->removeElement($monster);
            $monster->removeSkillbdd($this);
        }

        return $this;
    }

    /**
     * @return Collection|MonsterUser[]
     */
    public function getMonsterUsers(): Collection
    {
        return $this->monsterUsers;
    }

    public function addMonsterUser(MonsterUser $monsterUser): self
    {
        if (!$this->monsterUsers->contains($monsterUser)) {
            $this->monsterUsers[] = $monsterUser;
            $monsterUser->addSkillbdd($this);
        }

        return $this;
    }

    public function removeMonsterUser(MonsterUser $monsterUser): self
    {
        if ($this->monsterUsers->contains($monsterUser)) {
            $this->monsterUsers->removeElement($monsterUser);
            $monsterUser->removeSkillbdd($this);
        }

        return $this;
    }

    public function getCreateur(): ?int
    {
        return $this->createur;
    }

    public function setCreateur(?int $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    

    

    
}
