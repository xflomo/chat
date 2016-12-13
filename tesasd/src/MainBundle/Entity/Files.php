<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Imagick;
use Doctrine\ORM\EntityRepository;


/**
 * @ORM\Entity
 * @ORM\Table(name="files")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\FileRepository")
 */

class Files
{

    /**
     * @ORM\Column(type="bigint", length=150)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $uid;

    /**
     * @ORM\Column(name="urlPath", type="string", length=150)
     */
    private $urlPath;

    /**
     * @ORM\Column(name="originalName", type="string", length=50)
     */
    private $originalName;

    /**
     * @ORM\Column(name="hashName", type="string", length=50)
     */
    private $hashName;

    /**
     * @ORM\Column(name="typ", type="string", length=50)
     */
    private $typ;

    /**
     * @ORM\Column(name="size", type="bigint", length=20)
     */
    private $size;

    /**
     * @ORM\Column(name="changeTime", type="datetime")
     */
    private $changeTime;

    /**
     * @ORM\Column(name="trash", type="boolean")
     */
    private $trash;

    /**
     * @ORM\Column(name="owner", type="bigint", length=20)
     */
    private $owner;

    /**
     * @ORM\Column(name="thumbnail", type="string", length=100)
     */
    private $thumbnail = "thumbnail.png";

    /**
     * @ORM\Column(name="download", type="integer", length=5)
     */
    private $download;

    /**
     * @ORM\Column(name="uploadTime", type="datetime")
     */
    private $uploadTime;


    /**
     * Set uid
     *
     * @param integer $uid
     *
     * @return Files
     */
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }


    /**
     * Set urlPath
     *
     * @param string $urlPath
     *
     * @return Files
     */
    public function setUrlPath($urlPath)
    {
        $this->urlPath = $urlPath;

        return $this;
    }

    /**
     * Get urlPath
     *
     * @return string
     */
    public function getUrlPath()
    {
        return $this->urlPath;
    }

    /**
     * Set originalName
     *
     * @param string $originalName
     *
     * @return Files
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get originalName
     *
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * Set hashName
     *
     * @param string $hashName
     *
     * @return Files
     */
    public function setHashName($hashName)
    {
        $this->hashName = $hashName;

        return $this;
    }

    /**
     * Get hashName
     *
     * @return string
     */
    public function getHashName()
    {
        return $this->hashName;
    }

    /**
     * Set typ
     *
     * @param string $typ
     *
     * @return Files
     */
    public function setTyp($typ)
    {
        $this->typ = $typ;

        return $this;
    }

    /**
     * Get typ
     *
     * @return string
     */
    public function getTyp()
    {
        return $this->typ;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Files
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set changeTime
     *
     * @param \DateTime $changeTime
     *
     * @return Files
     */
    public function setChangeTime($changeTime)
    {
        $this->changeTime = $changeTime;

        return $this;
    }

    /**
     * Get changeTime
     *
     * @return \DateTime
     */
    public function getChangeTime()
    {
        return $this->changeTime;
    }

    /**
     * Set trash
     *
     * @param boolean $trash
     *
     * @return Files
     */
    public function setTrash($trash)
    {
        $this->trash = $trash;

        return $this;
    }

    /**
     * Get trash
     *
     * @return bool
     */
    public function getTrash()
    {
        return $this->trash;
    }

    /**
     * Set owner
     *
     * @param integer $owner
     *
     * @return Files
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return int
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return Files
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set download
     *
     * @param integer $download
     *
     * @return Files
     */
    public function setDownload($download)
    {
        $this->download = $download;

        return $this;
    }

    /**
     * Get download
     *
     * @return int
     */
    public function getDownload()
    {
        return $this->download;
    }

    /**
     * Set uploadTime
     *
     * @param \DateTime $uploadTime
     *
     * @return Files
     */
    public function setUploadTime($uploadTime)
    {
        $this->uploadTime = $uploadTime;

        return $this;
    }

    /**
     * Get uploadTime
     *
     * @return \DateTime
     */
    public function getUploadTime()
    {
        return $this->uploadTime;
    }

    public function getContent(){

    }


    public function createHashedFolder($username, $md5TempFile)
    {
        if(mkdir($this->getUploadRootDir().'/'.$username.'/'.$md5TempFile)){
            return true;
        }else{
            return false;
        }
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/uploads';
    }


    public function findeFile($path, $fileName)
    {
        $query = $this->entityManager->createQuery(
            'SELECT *
            FROM MainBundle:File f
            WHERE f.urlPath > :dirname
            AND f.originalName > :basename'
        )->setParameter('dirname', $path, 'basename', $fileName);

        return $query->getResult();
    }

    function getFileTmpNameHash($tempFile) {
        return md5_file($tempFile);
    }

    public function uploadFile($tempFile, $username)
    {

        $md5TempFile = $this->getFileTmpNameHash($tempFile);

        if($this->createHashedFolder($username ,$md5TempFile)){
            $targetFile =  $this->getUploadRootDir() .'/'. $username .'/'. $md5TempFile .'/'. $this->getOriginalName();  //5
            move_uploaded_file($tempFile,$targetFile);

            $this->createImageThumb($targetFile);
            return true;
        }else{
            return false;
        }


    }

    public function createImageThumb($image)
    {

        $imagine = new Imagine();

        $size    = new Box(400, 300);
        $mode    = ImageInterface::THUMBNAIL_OUTBOUND;
        $imageThumbPath = explode("/", $image);
        array_pop ($imageThumbPath);
        $imageThumbPath = implode("/", $imageThumbPath);
        $imagine->open($image)
            ->thumbnail($size, $mode)
            ->save($imageThumbPath.'/thumbnail.png')
        ;
    }
}

