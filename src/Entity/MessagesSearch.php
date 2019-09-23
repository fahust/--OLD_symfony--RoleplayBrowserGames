<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class MessagesSearch {

    /**
     * @var bool|null
     */
    private $sendByMe;

    /**
     * @var bool|null
     */
    private $sendForMe;

    /**
     * @param boolean|null $sendByMe
     * @return MessagesSearch
     */
    public function setSendByMe(bool $sendByMe): MessagesSearch
    {
        $this->sendByMe = $sendByMe;
        return $this;
    }
    /**
     * @param boolean|null $sendForMe
     * @return MessagesSearch
     */
    public function setSendForMe(bool $sendForMe): MessagesSearch
    {
        $this->sendForMe = $sendForMe;
        return $this;
    }
    /**
     * @return boolean|null
     */
    public function getSendByMe(): ?bool
    {
        return $this->sendByMe;
    }
    /**
     * @return boolean|null
     */
    public function getSendForMe(): ?bool
    {
        return $this->sendForMe;
    }
    


}