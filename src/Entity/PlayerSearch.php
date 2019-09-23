<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class PlayerSearch {

    /**
     * @var int|null
     */
    private $maxLevel;

    /**
     * @var int|null
     * @Assert\Range(min=10,max = 1000000)
     */
    private $minLevel;
    
    
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
     * @param integer|null $maxLevel
     * @return PlayerSearch
     */
    public function setMaxLevel(int $maxLevel): PlayerSearch
    {
        $this->maxLevel = $maxLevel;
        return $this;
    }
    /**
     * @param integer|null $minLevel
     * @return PlayerSearch
     */
    public function setMinLevel(int $minLevel): PlayerSearch
    {
        $this->minLevel = $minLevel;
        return $this;
    }
    /**
     * @return integer|null
     */
    public function getMaxLevel(): ?int
    {
        return $this->maxLevel;
    }
    /**
     * @return integer|null
     */
    public function getMinLevel(): ?int
    {
        return $this->minLevel;
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