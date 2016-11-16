<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SimonMusic
 *
 * @ORM\Table(name="simon_music")
 * @ORM\Entity
 */
class SimonMusic
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path_mp3", type="string", length=150, nullable=true)
     */
    private $pathMp3;

    /**
     * @var string
     *
     * @ORM\Column(name="path_img", type="string", length=150, nullable=true)
     */
    private $pathImg;

    /**
     * @var string
     *
     * @ORM\Column(name="link_site", type="string", length=30, nullable=true)
     */
    private $linkSite;

    /**
     * @var string
     *
     * @ORM\Column(name="link_url", type="string", length=100, nullable=true)
     */
    private $linkUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set name
     *
     * @param string $name
     * @return SimonMusic
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set pathMp3
     *
     * @param string $pathMp3
     * @return SimonMusic
     */
    public function setPathMp3($pathMp3)
    {
        $this->pathMp3 = $pathMp3;

        return $this;
    }

    /**
     * Get pathMp3
     *
     * @return string 
     */
    public function getPathMp3()
    {
        return $this->pathMp3;
    }

    /**
     * Set pathImg
     *
     * @param string $pathImg
     * @return SimonMusic
     */
    public function setPathImg($pathImg)
    {
        $this->pathImg = $pathImg;

        return $this;
    }

    /**
     * Get pathImg
     *
     * @return string 
     */
    public function getPathImg()
    {
        return $this->pathImg;
    }

    /**
     * Set linkSite
     *
     * @param string $linkSite
     * @return SimonMusic
     */
    public function setLinkSite($linkSite)
    {
        $this->linkSite = $linkSite;

        return $this;
    }

    /**
     * Get linkSite
     *
     * @return string 
     */
    public function getLinkSite()
    {
        return $this->linkSite;
    }

    /**
     * Set linkUrl
     *
     * @param string $linkUrl
     * @return SimonMusic
     */
    public function setLinkUrl($linkUrl)
    {
        $this->linkUrl = $linkUrl;

        return $this;
    }

    /**
     * Get linkUrl
     *
     * @return string 
     */
    public function getLinkUrl()
    {
        return $this->linkUrl;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return SimonMusic
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
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
}
