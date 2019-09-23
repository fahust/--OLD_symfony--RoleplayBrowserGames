<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class UserSearch {

    /**
     * @var string|null
     */
    private $ascusername;

    /**
     * @var string|null
     */
    private $descusername;

    /**
     * @param string|null $ascusername
     * @return UserSearch
     */
    public function setAscUsername(string $ascusername): UserSearch
    {
        $this->ascusername = $ascusername;
        return $this;
    }
    /**
     * @param string|null $descusername
     * @return UserSearch
     */
    public function setDescUsername(string $descusername): UserSearch
    {
        $this->descusername = $descusername;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getAscUsername(): ?string
    {
        return $this->ascusername;
    }
    /**
     * @return string|null
     */
    public function getDescUsername(): ?string
    {
        return $this->descusername;
    }
    


}