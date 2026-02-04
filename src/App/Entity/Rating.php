<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/28/16
 * Time: 3:06 PM
 */

namespace App\Entity;

use \App\Entity\Deal;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'Rating')]
#[ORM\Entity]
class Rating 
{
    use CreatePropertiesArrayTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var ?RatingCode
     */
    #[ORM\ManyToOne(targetEntity:  \App\Entity\RatingCode::class, inversedBy: 'ratings')]
    protected $ratingCode;

    /**
     * @var ?MarketUser
     */
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MarketUser::class, inversedBy: 'rated')]
    protected $rater;

    /**
     * @var ?MarketUser
     */
    #[ORM\ManyToOne(targetEntity:  \App\Entity\MarketUser::class, inversedBy: 'ratings')]
    protected $user;

    /**
     * @var ?Deal
     */
    #[ORM\ManyToOne(targetEntity: Deal::class, inversedBy: 'ratings')]
    protected $deal;
    
    public function __construct() {}

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return MarketUser
     */
    public function getUser() : MarketUser { return $this->user; }

    /**
     * @return ?RatingCode
     */
    public function getRatingCode():?RatingCode { return $this->ratingCode; }

    /**
     * @return MarketUser
     */
    public function getRater() :MarketUser { return $this->rater; }


}