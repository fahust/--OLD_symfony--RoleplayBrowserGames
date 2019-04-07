<?php

namespace App\Entity;

use App\Entity\Skill;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
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
    private $level;

    /**
     * @ORM\Column(type="integer")
     */
    private $experience;

    /**
     * @ORM\Column(type="integer")
     */
    private $skillpnt;

    /**
     * @ORM\Column(type="integer")
     */
    private $hp;

    /**
     * @ORM\Column(type="integer")
     */
    private $atk;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="players")
     */
    private $skillbdd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cible;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $skillnow;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="playerfight")
     */
    private $users;

    /**
     * @ORM\Column(type="integer")
     */
    private $createur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="playercreated")
     */
    private $usercreateur;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxhp;

    static private $skillpnt1;
    

    

    public  function __construct()
    {
        $this->skillbdd = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getSkillpnt(): ?int
    {
        return $this->skillpnt;
    }

    public function setSkillpnt(int $skillpnt): self
    {
        $this->skillpnt = $skillpnt;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getCible(): ?int
    {
        return $this->cible;
    }

    public function setCible(?int $cible): self
    {
        $this->cible = $cible;

        return $this;
    }

    public function getSkillnow(): ?int
    {
        return $this->skillnow;
    }

    public function setSkillnow(?int $skillnow): self
    {
        $this->skillnow = $skillnow;

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
            $user->addPlayerfight($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removePlayerfight($this);
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

    public function getUsercreateur(): ?User
    {
        return $this->usercreateur;
    }

    public function setUsercreateur(?User $usercreateur): self
    {
        $this->usercreateur = $usercreateur;

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
   

    

    public static function loadValidatorMetadata(ClassMetadata $metadata) 
    {
        
        $metadata->addPropertyConstraint('skillbdd', new Assert\Count([
            'min'        => 1,
            'max'        => 10,
            'minMessage' => 'Tu dois sélectioner aux moins une compétences',
            'maxMessage' => 'Tu ne dois pas sélectioner plus de {{ limit }} compétences ',
        ]));
    }

    
}
