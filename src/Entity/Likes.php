<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikesRepository")
 */
class Likes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Player", inversedBy="likes")
     */
    private $players;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="likes")
     */
    private $skills;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\QuestVariable", inversedBy="likes")
     */
    private $quests;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Monster", inversedBy="likes")
     */
    private $monsters;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Objet", inversedBy="likes")
     */
    private $objets;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="likes")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="likessend")
     * @ORM\JoinColumn(nullable=false)
     */
    private $byuser;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->quests = new ArrayCollection();
        $this->monsters = new ArrayCollection();
        $this->objets = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
        }

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
        }

        return $this;
    }

    /**
     * @return Collection|QuestVariable[]
     */
    public function getQuests(): Collection
    {
        return $this->quests;
    }

    public function addQuest(QuestVariable $quest): self
    {
        if (!$this->quests->contains($quest)) {
            $this->quests[] = $quest;
        }

        return $this;
    }

    public function removeQuest(QuestVariable $quest): self
    {
        if ($this->quests->contains($quest)) {
            $this->quests->removeElement($quest);
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
        }

        return $this;
    }

    public function removeMonster(Monster $monster): self
    {
        if ($this->monsters->contains($monster)) {
            $this->monsters->removeElement($monster);
        }

        return $this;
    }

    /**
     * @return Collection|Objet[]
     */
    public function getObjets(): Collection
    {
        return $this->objets;
    }

    public function addObjet(Objet $objet): self
    {
        if (!$this->objets->contains($objet)) {
            $this->objets[] = $objet;
        }

        return $this;
    }

    public function removeObjet(Objet $objet): self
    {
        if ($this->objets->contains($objet)) {
            $this->objets->removeElement($objet);
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
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getByuser(): ?User
    {
        return $this->byuser;
    }

    public function setByuser(?User $byuser): self
    {
        $this->byuser = $byuser;

        return $this;
    }

    
}
