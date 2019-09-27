<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class ObjetSearch {


    /**
     * @var int|null
     */
    private $createdByMe;


    /**
     * @var string|null
     */
    private $language;


    /**
     * @var string|null
     */
    private $type;

    /**
     * @var int|null
     */
    private $maxHp;

    /**
     * @var int|null
     * @Assert\Range(min=1,max = 1000000)
     */
    private $minHp;
    
    
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
     * @return ObjetSearch
     */
    public function setMaxHp(int $maxHp): ObjetSearch
    {
        $this->maxHp = $maxHp;
        return $this;
    }
    /**
     * @param integer|null $minHp
     * @return ObjetSearch
     */
    public function setMinHp(int $minHp): ObjetSearch
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
     * @return ObjetSearch
     */
    public function setNameAsc(bool $nameAsc): ObjetSearch
    {
        $this->nameAsc = $nameAsc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return ObjetSearch
     */
    public function setNameDesc(bool $nameDesc): ObjetSearch
    {
        $this->nameDesc = $nameDesc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return ObjetSearch
     */
    public function setLikeAsc(bool $likeAsc): ObjetSearch
    {
        $this->likeAsc = $likeAsc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return ObjetSearch
     */
    public function setLikeDesc(bool $likeDesc): ObjetSearch
    {
        $this->likeDesc = $likeDesc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return ObjetSearch
     */
    public function setDateAsc(bool $dateAsc): ObjetSearch
    {
        $this->dateAsc = $dateAsc;
        return $this;
    }
    /**
     * @param boolean|null $minHp
     * @return ObjetSearch
     */
    public function setDateDesc(bool $dateDesc): ObjetSearch
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
     * @return ObjetSearch
     */
    public function setChoiceNbrPerPage(int $choiceNbrPerPage): ObjetSearch
    {
        $this->choiceNbrPerPage = $choiceNbrPerPage;
        return $this;
    }

    
    /**
     * @return integer|null
     */
    public function getCreatedByMe(): ?int
    {
        return $this->createdByMe;
    }


    /**
     * @param integer|null $createdByMe
     * @return ObjetSearch
     */
    public function setCreatedByMe(int $createdByMe): ObjetSearch
    {
        $this->createdByMe = $createdByMe;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?int
    {
        return $this->language;
    }
    /**
     * @param string|null $language
     * @return ObjetSearch
     */
    public function setLanguage(int $language): ObjetSearch
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }
    /**
     * @param string|null $type
     * @return ObjetSearch
     */
    public function setType(int $type): ObjetSearch
    {
        $this->type = $type;
        return $this;
    }
    
    


}