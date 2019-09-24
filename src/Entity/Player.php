<?php

namespace App\Entity;

use App\Entity\Skill;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 * @Vich\Uploadable
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
     * @ORM\Column(type="integer")
     */
    private $mana;

    /**
     * @ORM\Column(type="integer")
     */
    private $esq;

    /**
     * @ORM\Column(type="integer")
     */
    private $def;

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
    private $maxmana;
    
    
    /**
    * @ORM\Column(type="datetime")
    */
   private $updatedAt;

   /**
    * NOTE: This is not a mapped field of entity metadata, just a simple property.
    * 
    * @Vich\UploadableField(mapping="monster", fileNameProperty="imageName")
    * @ORM\Column( nullable=true)
    * @Assert\File(maxSize = "512k",
    * maxSizeMessage = "Le fichier est trop grand ({{ size }} {{ suffix }}). Taille maximum authorisé {{ limit }} {{ suffix }}"
    * )
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
    * @ORM\ManyToMany(targetEntity="App\Entity\Likes", mappedBy="players")
    */
   private $likes;

   /**
    * @ORM\ManyToMany(targetEntity="App\Entity\Dislikes", mappedBy="players")
    */
   private $dislikes;

    

    

    public  function __construct()
    {
        $this->skillbdd = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->updateAt = new \Datetime();
        $this->likes = new ArrayCollection();
        $this->dislikes = new ArrayCollection();
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

    public function getMana(): ?int
    {
        return $this->mana;
    }

    public function setMana(int $mana): self
    {
        $this->mana = $mana;

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

    public function getMaxmana(): ?int
    {
        return $this->maxmana;
    }

    public function setMaxmana(int $maxmana): self
    {
        $this->maxmana = $maxmana;

        return $this;
    }



    

    public function getUpdatedAt(): ?\DateTimeInterface
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



    

    public static function loadValidatorMetadata(ClassMetadata $metadata) 
    {
        
        $metadata->addPropertyConstraint('skillbdd', new Assert\Count([
            'min'        => 1,
            'max'        => 10,
            'minMessage' => 'Tu dois sélectioner aux moins une compétences',
            'maxMessage' => 'Tu ne dois pas sélectioner plus de {{ limit }} compétences ',
        ]));
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
            $like->addPlayer($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            $like->removePlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection|Dislikes[]
     */
    public function getDislikes(): Collection
    {
        return $this->dislikes;
    }

    public function addDislike(Dislikes $dislike): self
    {
        if (!$this->dislikes->contains($dislike)) {
            $this->dislikes[] = $dislike;
            $dislike->addPlayer($this);
        }

        return $this;
    }

    public function removeDislike(Dislikes $dislike): self
    {
        if ($this->dislikes->contains($dislike)) {
            $this->dislikes->removeElement($dislike);
            $dislike->removePlayer($this);
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
