<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userinchatroom
 *
 * @ORM\Table(name="userInChatroom")
 * @ORM\Entity
 */
class Userinchatroom
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="joinTime", type="datetime", nullable=false)
     */
    private $jointime;

    /**
     * @var integer
     *
     * @ORM\Column(name="userId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $userid;

    /**
     * @var integer
     *
     * @ORM\Column(name="chatroomId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $chatroomid;



    /**
     * Set jointime
     *
     * @param \DateTime $jointime
     *
     * @return Userinchatroom
     */
    public function setJointime($jointime)
    {
        $this->jointime = $jointime;

        return $this;
    }

    /**
     * Get jointime
     *
     * @return \DateTime
     */
    public function getJointime()
    {
        return $this->jointime;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     *
     * @return Userinchatroom
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set chatroomid
     *
     * @param integer $chatroomid
     *
     * @return Userinchatroom
     */
    public function setChatroomid($chatroomid)
    {
        $this->chatroomid = $chatroomid;

        return $this;
    }

    /**
     * Get chatroomid
     *
     * @return integer
     */
    public function getChatroomid()
    {
        return $this->chatroomid;
    }
}
