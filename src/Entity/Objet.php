<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjetRepository")
 * @Vich\Uploadable
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Likes", mappedBy="objets")
     */
    private $likes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Dislikes", mappedBy="objets")
     */
    private $dislikes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->questVariables = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->questvariablesrequismany = new ArrayCollection();
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
            $like->addObjet($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            $like->removeObjet($this);
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
            $dislike->addObjet($this);
        }

        return $this;
    }

    public function removeDislike(Dislikes $dislike): self
    {
        if ($this->dislikes->contains($dislike)) {
            $this->dislikes->removeElement($dislike);
            $dislike->removeObjet($this);
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
