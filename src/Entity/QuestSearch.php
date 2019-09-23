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
    


}