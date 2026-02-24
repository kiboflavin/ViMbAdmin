<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Quota
 */
class Quota
{
    /**
     * @var string $username
     */
    private $username;

    /**
     * @var integer $bytes
     */
    private $bytes;

    /**
     * @var integer $messages
     */
    private $messages;

    /**
     * Set username
     *
     * @param string $username
     * @return Quota
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set bytes
     *
     * @param integer $bytes
     * @return Quota
     */
    public function setBytes($bytes)
    {
        $this->bytes = $bytes;

        return $this;
    }

    /**
     * Get bytes
     *
     * @return integer
     */
    public function getBytes()
    {
        return $this->bytes;
    }

    /**
     * Set messages
     *
     * @param integer $messages
     * @return Quota
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get messages
     *
     * @return integer
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
