<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class MonsterSearch {

    /**
     * @var int|null
     */
    private $maxHp;

    /**
     * @var int|null
     * @Assert\Range(min=10,max = 1000000)
     */
    private $minHp;

    /**
     * @param integer|null $maxHp
     * @return MonsterSearch
     */
    public function setMaxHp(int $maxHp): MonsterSearch
    {
        $this->maxHp = $maxHp;
        return $this;
    }
    /**
     * @param integer|null $minHp
     * @return MonsterSearch
     */
    public function setMinHp(int $minHp): MonsterSearch
    {
        $this->minHp = $minHp;
        return $this;
    }
    /**
     * @return integer|null
     */
    public function getMaxHp(): ?int
    {
        return $this->maxHp;
    }
    /**
     * @return integer|null
     */
    public function getMinHp(): ?int
    {
        return $this->minHp;
    }
    


}