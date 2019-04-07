<?php

namespace App\Entity;

use App\Entity\Skill;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MonsterRepository")
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

    

    
    public function __construct()
    {
        $this->skillbdd = new ArrayCollection();
        $this->questVariables = new ArrayCollection();
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

    

    

    
}
