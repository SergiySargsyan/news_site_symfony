<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RatingRepository")
 */
class Rating
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
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Comment", inversedBy="id")
     * @ORM\Column(name="comment_id", type="integer")
     */
    private $commentId;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="id" )
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="pick", type="string", length=1)
     */
    private $pick;


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
     * Set commentId
     *
     * @param integer $commentId
     *
     * @return Rating
     */
    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;

        return $this;
    }

    /**
     * Get commentId
     *
     * @return int
     */
    public function getCommentId()
    {
        return $this->commentId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Rating
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set pick
     *
     * @param string $pick
     *
     * @return Rating
     */
    public function setPick($pick)
    {
        $this->pick = $pick;

        return $this;
    }

    /**
     * Get pick
     *
     * @return string
     */
    public function getPick()
    {
        return $this->pick;
    }
}
