<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class QuestSearch {

    /**
     * @var int|null
     */
    private $maxdedifficult;

    /**
     * @var int|null
     * @Assert\Range(min=10,max = 1000000)
     */
    private $mindedifficult;
    
    
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
     * @param integer|null $maxdedifficult
     * @return QuestSearch
     */
    public function setMaxDeDifficult(int $maxdedifficult): QuestSearch
    {
        $this->maxdedifficult = $maxdedifficult;
        return $this;
    }
    /**
     * @param integer|null $mindedifficult
     * @return QuestSearch
     */
    public function setMinDeDifficult(int $mindedifficult): QuestSearch
    {
        $this->mindedifficult = $mindedifficult;
        return $this;
    }
    /**
     * @return integer|null
     */
    public function getMaxDeDifficult(): ?int
    {
        return $this->maxdedifficult;
    }
    /**
     * @return integer|null
     */
    public function getMinDeDifficult(): ?int
    {
        return $this->mindedifficult;
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
    public function setNameAsc(bool $nameAsc): QuestSearch
    {
        $this->nameAsc = $nameAsc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setNameDesc(bool $nameDesc): QuestSearch
    {
        $this->nameDesc = $nameDesc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setLikeAsc(bool $likeAsc): QuestSearch
    {
        $this->likeAsc = $likeAsc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setLikeDesc(bool $likeDesc): QuestSearch
    {
        $this->likeDesc = $likeDesc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setDateAsc(bool $dateAsc): QuestSearch
    {
        $this->dateAsc = $dateAsc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return SkillSearch
     */
    public function setDateDesc(bool $dateDesc): QuestSearch
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
    public function setChoiceNbrPerPage(int $choiceNbrPerPage): QuestSearch
    {
        $this->choiceNbrPerPage = $choiceNbrPerPage;
        return $this;
    }
    


}