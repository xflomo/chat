<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chatroom
 *
 * @ORM\Table(name="chatroom", uniqueConstraints={@ORM\UniqueConstraint(name="uid", columns={"uid"}), @ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Chatroom
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="owner", type="integer", nullable=false)
     */
    private $owner;

    /**
     * @var integer
     *
     * @ORM\Column(name="admin", type="integer", nullable=false)
     */
    private $admin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createTime", type="datetime", nullable=false)
     */
    private $createtime;

    /**
     * @var integer
     *
     * @ORM\Column(name="uid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $uid;



    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Chatroom
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set owner
     *
     * @param integer $owner
     *
     * @return Chatroom
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return integer
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set admin
     *
     * @param integer $admin
     *
     * @return Chatroom
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return integer
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set createtime
     *
     * @param \DateTime $createtime
     *
     * @return Chatroom
     */
    public function setCreatetime($createtime)
    {
        $this->createtime = $createtime;

        return $this;
    }

    /**
     * Get createtime
     *
     * @return \DateTime
     */
    public function getCreatetime()
    {
        return $this->createtime;
    }

    /**
     * Get uid
     *
     * @return integer
     */
    public function getUid()
    {
        return $this->uid;
    }
}
