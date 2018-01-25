<?php

namespace AppBundle\Entity;

/**
 * Post
 */
class Post {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $image;

    /**
     * @var integer
     */
    private $likes;

    /**
     * @var integer
     */
    private $comments;

    /**
     * @var integer
     */
    private $reposts;

    /**
     * @var integer
     */
    private $foreign_id;

    /**
     * @var \DateTime
     */
    private $publicated_at;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Post
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Post
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Post
     */
    public function setLikes($likes) {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer
     */
    public function getLikes() {
        return $this->likes;
    }

    /**
     * Set comments
     *
     * @param integer $comments
     *
     * @return Post
     */
    public function setComments($comments) {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return integer
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Set reposts
     *
     * @param integer $reposts
     *
     * @return Post
     */
    public function setReposts($reposts) {
        $this->reposts = $reposts;

        return $this;
    }

    /**
     * Get reposts
     *
     * @return integer
     */
    public function getReposts() {
        return $this->reposts;
    }

    /**
     * Set foreignId
     *
     * @param integer $foreignId
     *
     * @return Post
     */
    public function setForeignId($foreignId) {
        $this->foreign_id = $foreignId;

        return $this;
    }

    /**
     * Get foreignId
     *
     * @return integer
     */
    public function getForeignId() {
        return $this->foreign_id;
    }

    /**
     * Set publicatedAt
     *
     * @param \DateTime $publicatedAt
     *
     * @return Post
     */
    public function setPublicatedAt($publicatedAt) {
        $this->publicated_at = $publicatedAt;

        return $this;
    }

    /**
     * Get publicatedAt
     *
     * @return \DateTime
     */
    public function getPublicatedAt() {
        return $this->publicated_at;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Post
     */
    public function setCreatedAt($createdAt) {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Post
     */
    public function setUpdatedAt($updatedAt) {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->created_at) {
            $this->created_at = new \DateTime('now');
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue() {
        if (!$this->updated_at) {
            $this->updated_at = new \DateTime('now');
        }
    }

}
