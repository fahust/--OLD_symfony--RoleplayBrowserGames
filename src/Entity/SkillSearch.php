<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class SkillSearch {

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
     * @var string|null
     */
    private $Regex;
    
    
    /**
    * @var bool|null
    * @Assert\Range(min=0,max = 1000000)
    */
   private $likeAsc;

   
   /**
   * @var bool|null
   * @Assert\Range(min=0,max = 1000000)
   */
    private $likeDesc;

   
    /**
    * @var bool|null
    * @Assert\Range(min=0,max = 1000000)
    */
     private $nameAsc;

   
     /**
     * @var bool|null
     * @Assert\Range(min=0,max = 1000000)
     */
      private $nameDesc;

   
      /**
      * @var bool|null
      * @Assert\Range(min=0,max = 1000000)
      */
       private $dateAsc;
  
     
       /**
       * @var bool|null
       * @Assert\Range(min=0,max = 1000000)
       */
        private $dateDesc;

    /**
     * @param integer|null $maxHp
     * @return SkillSearch
     */
    public function setMaxHp(int $maxHp): SkillSearch
    {
        $this->maxHp = $maxHp;
        return $this;
    }
    /**
     * @param integer|null $minHp
     * @return SkillSearch
     */
    public function setMinHp(int $minHp): SkillSearch
    {
        $this->minHp = $minHp;
        return $this;
    }
    /**
     * @param integer|null $minHp
     * @return MonsterSearch
     */
    public function setRegex(string $Regex): SkillSearch
    {
        $this->Regex = $Regex;
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
    /**
     * @return string|null
     */
    public function getRegex(): ?string
    {
        return $this->Regex;
    }
    
    /**
     * @return bool|null
     */
    public function getlikeAsc(): ?bool
    {
        return $this->likeAsc;
    }
    /**
     * @return bool|null
     */
    public function getlikeDesc(): ?bool
    {
        return $this->likeDesc;
    }
    
    /**
     * @return bool|null
     */
    public function getnameAsc(): ?bool
    {
        return $this->nameAsc;
    }
    /**
     * @return bool|null
     */
    public function getnameDesc(): ?bool
    {
        return $this->nameDesc;
    }
    
    /**
     * @return bool|null
     */
    public function getdateAsc(): ?bool
    {
        return $this->dateAsc;
    }
    /**
     * @return bool|null
     */
    public function getdateDesc(): ?bool
    {
        return $this->dateDesc;
    }
    


}