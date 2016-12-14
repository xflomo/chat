<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tokens
 *
 * @ORM\Table(name="tokens", uniqueConstraints={@ORM\UniqueConstraint(name="uid", columns={"uid"}), @ORM\UniqueConstraint(name="token", columns={"token"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TokenRepository")
 * @ORM\Entity
 */
class Tokens
{
    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=200, nullable=false)
     */
    private $token;

    /**
     * @var integer
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userid;

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
     * Set token
     *
     * @param string $token
     *
     * @return Tokens
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     *
     * @return Tokens
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
     * Set createtime
     *
     * @param \DateTime $createtime
     *
     * @return Tokens
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
