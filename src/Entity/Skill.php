<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkillRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(type="bool")
     */
    private $destinataire;

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

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="monster", fileNameProperty="imageName")
     * @ORM\Column( nullable=true)
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Likes", mappedBy="skills")
     */
    private $likes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    

    

    

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->monsters = new ArrayCollection();
        $this->monsterUsers = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->updateAt = new \Datetime();
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

    public function getDestinataire(): ?bool
    {
        return $this->destinataire;
    }

    public function setDestinataire(bool $destinataire): self
    {
        $this->destinataire = $destinataire;

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
    }public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @return Collection|Likes[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Likes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->addSkill($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            $like->removeSkill($this);
        }

        return $this;
    }
    
    /** 
     * Permet de savoir si cet article est liké par un utilisateur
     * 
    */

    
    public function isLikedByUser(User $user)  {
        foreach($this->likes as $like) {
            if($like->getByuser() === $user) return $like;
        }

        return false;
    }

    public function getNbrlike(): ?int
    {
        return $this->nbrlike;
    }

    public function setNbrlike(int $nbrlike): self
    {
        $this->nbrlike = $nbrlike;

        return $this;
    }

    

    

    
}
