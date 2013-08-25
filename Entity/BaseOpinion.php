<?php

namespace Prism\PollBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Prism\PollBundle\Entity\BasePoll;
use Prism\PollBundle\Entity\Poll;

/**
 * Prism\PollBundle\Entity\BaseOpinion
 * @ORM\MappedSuperclass
 */
abstract class BaseOpinion
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
     * @var integer $votes
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $votes;

    /**
     * @var integer $ordering
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $ordering;

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
     * @var \Prism\PollBundle\Entity\BasePoll
     * @ORM\ManyToOne(targetEntity="Poll", inversedBy="opinions", cascade={"remove"})
     * @ORM\JoinColumn(name="pollId", referencedColumnName="id")
     */
    protected $poll;

    /**
     * @var float $votesPercentage
     * @ORM\Column(type="float", nullable=true)
     */
    protected $votesPercentage;


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
     * Set votes
     *
     * @param integer $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    }

    /**
     * Get votes
     *
     * @return integer 
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set ordering
     *
     * @param integer $ordering
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;
    }

    /**
     * Get ordering
     *
     * @return integer 
     */
    public function getOrdering()
    {
        return $this->ordering;
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
     * Set poll
     *
     * @param \Prism\PollBundle\Entity\BasePoll $poll
     */
    public function setPoll(\Prism\PollBundle\Entity\BasePoll $poll)
    {
        $this->poll = $poll;
    }

    /**
     * Get poll
     *
     * @return \Prism\PollBundle\Entity\BasePoll
     */
    public function getPoll()
    {
        return $this->poll;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->id) {
            return $this->name;
        }

        return 'New Choice';
    }

    /**
     * Get the votes percentage
     *
     * @return float
     */
    public function getVotesPercentage()
    {
        if ($this->votesPercentage) {
            return $this->votesPercentage;
        }

        if ($this->poll->getTotalVotes() > 0) {
            return $this->votesPercentage = round($this->votes / $this->poll->getTotalVotes() * 100);
        }

        return 0;
    }
}