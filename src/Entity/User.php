<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields= {"email"},
 * message="L'email que vous avez indiqué est déja utilisé"
 *  )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas taper le même mot de passe")
     */
    public $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonsterUser", mappedBy="user")
     */
    private $monsterUsers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Player", inversedBy="users")
     */
    private $playerfight;

    /**
     * @ORM\Column(type="integer")
     */
    private $tour;

    /**
     * @ORM\Column(type="integer")
     */
    private $action;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Player", mappedBy="usercreateur")
     */
    private $playercreated;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Objet", inversedBy="users")
     */
    private $objet;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Groups", inversedBy="users")
     */
    private $Groups;

    

    

    public function __construct()
    {
        $this->monsterUsers = new ArrayCollection();
        $this->playerfight = new ArrayCollection();
        $this->playercreated = new ArrayCollection();
        $this->objet = new ArrayCollection();
        $this->Groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(){

    }

    public function getSalt() {

    }

    public function getRoles(){
        return ['ROLE_USER'];
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
            $monsterUser->setUser($this);
        }

        return $this;
    }

    public function removeMonsterUser(MonsterUser $monsterUser): self
    {
        if ($this->monsterUsers->contains($monsterUser)) {
            $this->monsterUsers->removeElement($monsterUser);
            // set the owning side to null (unless already changed)
            if ($monsterUser->getUser() === $this) {
                $monsterUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayerfight(): Collection
    {
        return $this->playerfight;
    }

    public function addPlayerfight(Player $playerfight): self
    {
        if (!$this->playerfight->contains($playerfight)) {
            $this->playerfight[] = $playerfight;
        }

        return $this;
    }

    public function removePlayerfight(Player $playerfight): self
    {
        if ($this->playerfight->contains($playerfight)) {
            $this->playerfight->removeElement($playerfight);
        }

        return $this;
    }

    public function getTour(): ?int
    {
        return $this->tour;
    }

    public function setTour(int $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    public function getAction(): ?int
    {
        return $this->action;
    }

    public function setAction(int $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayercreated(): Collection
    {
        return $this->playercreated;
    }

    public function addPlayercreated(Player $playercreated): self
    {
        if (!$this->playercreated->contains($playercreated)) {
            $this->playercreated[] = $playercreated;
            $playercreated->setUsercreateur($this);
        }

        return $this;
    }

    public function removePlayercreated(Player $playercreated): self
    {
        if ($this->playercreated->contains($playercreated)) {
            $this->playercreated->removeElement($playercreated);
            // set the owning side to null (unless already changed)
            if ($playercreated->getUsercreateur() === $this) {
                $playercreated->setUsercreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Objet[]
     */
    public function getObjet(): Collection
    {
        return $this->objet;
    }

    public function addObjet(Objet $objet): self
    {
        if (!$this->objet->contains($objet)) {
            $this->objet[] = $objet;
        }

        return $this;
    }

    public function removeObjet(Objet $objet): self
    {
        if ($this->objet->contains($objet)) {
            $this->objet->removeElement($objet);
        }

        return $this;
    }

    /**
     * @return Collection|Groups[]
     */
    public function getGroups(): Collection
    {
        return $this->Groups;
    }

    public function addGroup(Groups $group): self
    {
        if (!$this->Groups->contains($group)) {
            $this->Groups[] = $group;
        }

        return $this;
    }

    public function removeGroup(Groups $group): self
    {
        if ($this->Groups->contains($group)) {
            $this->Groups->removeElement($group);
        }

        return $this;
    }

    public function hasGroup($groupName)
    {
        foreach($this->Groups as $group){
            if($group->name == $groupName){
                return true;
            }
        }

        return false;
    }

   

    
}
