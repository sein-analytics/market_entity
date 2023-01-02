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
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="Rating")
 */
class Rating extends AnnotationMappings
{
    use CreatePropertiesArrayTrait;

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\RatingCode", inversedBy="ratings")
     * @var ?RatingCode
     */
    protected $ratingCode;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="rated")
     * @var ?MarketUser
     */
    protected $rater;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="ratings")
     * @var ?MarketUser
     */
    protected $user;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="ratings")
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