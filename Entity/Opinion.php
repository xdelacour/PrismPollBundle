<?php

namespace Prism\PollBundle\Entity;

use Prism\PollBundle\Entity\BaseOpinion;
use Doctrine\ORM\Mapping as ORM;

/**
 * Prism\PollBundle\Entity\Opinion
 * @ORM\Entity(repositoryClass="OpinionRepository")
 * @ORM\Table(name="pollopinion")
 */
class Opinion extends BaseOpinion
{
}