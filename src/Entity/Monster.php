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
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MonsterRepository")
 * @Vich\Uploadable
 */
class Monster
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Skill", inversedBy="monsters")
     */
    private $skillbdd;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\QuestVariable", mappedBy="monsters")
     */
    private $questVariables;

    

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
     * @ORM\ManyToMany(targetEntity="App\Entity\Likes", mappedBy="monsters")
     */
    private $likes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Dislikes", mappedBy="monsters")
     */
    private $dislikes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    
    public function __construct()
    {
        $this->skillbdd = new ArrayCollection();
        $this->questVariables = new ArrayCollection();
        $this->updateAt = new \Datetime();
        $this->likes = new ArrayCollection();
        $this->dislikes = new ArrayCollection();
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

    public function setImage( ?string $image): self
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
            $questVariable->addMonster($this);
        }

        return $this;
    }

    public function removeQuestVariable(QuestVariable $questVariable): self
    {
        if ($this->questVariables->contains($questVariable)) {
            $this->questVariables->removeElement($questVariable);
            $questVariable->removeMonster($this);
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
            $like->addMonster($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            $like->removeMonster($this);
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
            $dislike->addMonster($this);
        }

        return $this;
    }

    public function removeDislike(Dislikes $dislike): self
    {
        if ($this->dislikes->contains($dislike)) {
            $this->dislikes->removeElement($dislike);
            $dislike->removeMonster($this);
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
