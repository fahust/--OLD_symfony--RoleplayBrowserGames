<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class MonsterSearch {


    /**
     * @var int|null
     */
    private $name;


    /**
     * @var int|null
     */
    private $createdByMe;


    /**
     * @var int|null
     */
    private $language;

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
    */
   private $likeAsc;

   
   /**
   * @var bool|null
   */
    private $likeDesc;

   
    /**
    * @var bool|null
    */
     private $nameAsc;

   
     /**
     * @var bool|null
     */
      private $nameDesc;

   
      /**
      * @var bool|null
      */
       private $dateAsc;
  
     
       /**
       * @var bool|null
       */
        private $dateDesc;
  
     
        /**
        * @var int|null
        * @Assert\Range(min=3,max = 18)
        */
         private $choiceNbrPerPage;



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
     * @param integer|null $minHp
     * @return MonsterSearch
     */
    public function setRegex(string $Regex): MonsterSearch
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
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setNameAsc(bool $nameAsc): MonsterSearch
    {
        $this->nameAsc = $nameAsc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setNameDesc(bool $nameDesc): MonsterSearch
    {
        $this->nameDesc = $nameDesc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setLikeAsc(bool $likeAsc): MonsterSearch
    {
        $this->likeAsc = $likeAsc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setLikeDesc(bool $likeDesc): MonsterSearch
    {
        $this->likeDesc = $likeDesc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setDateAsc(bool $dateAsc): MonsterSearch
    {
        $this->dateAsc = $dateAsc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setDateDesc(bool $dateDesc): MonsterSearch
    {
        $this->dateDesc = $dateDesc;
        return $this;
    }
    /**
     * @return integer|null
     */
    public function getChoiceNbrPerPage(): ?int
    {
        return $this->choiceNbrPerPage;
    }
    /**
     * @param integer|null $choiceNbrPerPage
     * @return SkillSearch
     */
    public function setChoiceNbrPerPage(int $choiceNbrPerPage): MonsterSearch
    {
        $this->choiceNbrPerPage = $choiceNbrPerPage;
        return $this;
    }
    


}