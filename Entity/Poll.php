<?php

namespace Prism\PollBundle\Entity;

use Prism\PollBundle\Entity\BasePoll;
use Doctrine\ORM\Mapping as ORM;

/**
 * Prism\PollBundle\Entity\Poll
 * @ORM\Entity(repositoryClass="PollRepository")
 * @ORM\Table(name="poll")
 */
class Poll extends BasePoll
{   
}