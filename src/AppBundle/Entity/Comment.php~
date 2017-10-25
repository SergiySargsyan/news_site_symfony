<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="comments")
     */
    private $user;

    /**
     * @var ArrayCollection
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\News", inversedBy="comments")
     */
    private $news;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="countLike", type="integer", nullable=true)
     */
    private $countLike;

    /**
     * @var int
     *
     * @ORM\Column(name="countDislike", type="integer", nullable=true)
     */
    private $countDislike;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parent;

    /**
     * @var bool
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $visible;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $user
     *
     * @return Comment
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get userId
     *
     * @return ArrayCollection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set news
     *
     * @param integer $news
     *
     * @return Comment
     */
    public function setNews($news)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get newsId
     *
     * @return ArrayCollection
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comment
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
     * Set countLike
     *
     * @param integer $countLike
     *
     * @return Comment
     */
    public function setCountLike($countLike)
    {
        $this->countLike = $countLike;

        return $this;
    }

    /**
     * Get countLike
     *
     * @return int
     */
    public function getCountLike()
    {
        return $this->countLike;
    }

    /**
     * Set countDislike
     *
     * @param integer $countDislike
     *
     * @return Comment
     */
    public function setCountDislike($countDislike)
    {
        $this->countDislike = $countDislike;

        return $this;
    }

    /**
     * Get countDislike
     *
     * @return int
     */
    public function getCountDislike()
    {
        return $this->countDislike;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set parentId
     *
     * @param integer $parent
     *
     * @return Comment
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return Comment
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return bool
     */
    public function getVisible()
    {
        return $this->visible;
    }
}
