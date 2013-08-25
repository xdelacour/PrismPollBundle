<?php

namespace Prism\PollBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Prism\PollBundle\Entity\BaseOpinion;
use Prism\PollBundle\Entity\Opinion;

/**
 * Prism\PollBundle\Entity\BasePoll
 * @ORM\MappedSuperclass
 */
abstract class BasePoll
{
    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string $slug
     * @Gedmo\Slug(fields={"name"}, separator="-")
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $slug;

    /**
     * @var boolean $published
     * @ORM\Column(type="boolean")
     */
    protected $published;

    /**
     * @var boolean $closed
     * @ORM\Column(type="boolean")
     */
    protected $closed;

    /**
     * @var \Datetime $createdAt
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \Datetime $updatedAt
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @var \Prism\PollBundle\Entity\BaseOpinion
     * @ORM\OneToMany(targetEntity="Opinion", mappedBy="poll", cascade={"persist"})
     */
    protected $opinions;

    /**
     * @var integer $totalVotes
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $totalVotes;

    /**
     * __construct()
     */
    public function __construct()
    {
        $this->opinions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set published
     *
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set closed
     *
     * @param boolean $closed
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * Get closed
     *
     * @return boolean 
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set createdAt
     *
     * @param \Datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \Datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return \Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add opinions
     *
     * @param \Prism\PollBundle\Entity\BaseOpinion $opinions
     */
    public function addOpinion(\Prism\PollBundle\Entity\BaseOpinion $opinions)
    {
        $this->opinions[] = $opinions;
    }

    /**
     * Remove opinions
     *
     * @param \Prism\PollBundle\Entity\BaseOpinion $opinions
     */
    public function removeOpinion(\Prism\PollBundle\Entity\BaseOpinion $opinions)
    {
        if (($key = $this->opinions->indexOf($opinions)) !== false) {
            $this->opinions->remove($key);
        }
    }

    /**
     * Get opinions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpinions()
    {
        return $this->opinions;
    }

    /**
     * Set opinions
     *
     * @param \Doctrine\Common\Collections\Collection $opinions
     */
    public function setOpinions(\Doctrine\Common\Collections\Collection $opinions)
    {
        foreach ($opinions as $opinion) {
            $opinion->setPoll($this);
        }

        $this->opinions = $opinions;
    }

    /**
     * Get the total number of votes
     *
     * @return int
     */
    public function getTotalVotes()
    {
        if ($this->totalVotes) {
            return $this->totalVotes;
        }

        $this->totalVotes = 0;

        foreach ($this->opinions as $opinion) {
            $this->totalVotes += $opinion->getVotes();
        }

        return $this->totalVotes;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->id && $this->name) {
            return $this->name;
        }

        return 'New Poll';
    }
}