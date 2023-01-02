<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/28/16
 * Time: 3:06 PM
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Rating")
 */
class Rating 
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\RatingCode", inversedBy="ratings")
     * @var ?RatingCode
     */
    protected $ratingCode;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="rated")
     * @var ?MarketUser
     */
    protected $rater;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="ratings")
     * @var ?MarketUser
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="ratings")
     * @var ?Deal
     */
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