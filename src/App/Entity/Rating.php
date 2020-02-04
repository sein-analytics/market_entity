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
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\RatingCode", inversedBy="ratings")
     * @var RatingCode
     */
    protected $ratingCode;

    /** @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="rated") **/
    protected $rater;

    /** @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser", inversedBy="ratings") **/
    protected $user;

    /** @ORM\ManyToOne(targetEntity="\App\Entity\Deal", inversedBy="ratings") **/
    protected $deal;
    
    public function __construct() {}

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return MarketUser
     */
    public function getUser() : MarketUser { return $this->user; }

    /**
     * @return mixed
     */
    public function getRatingCode() { return $this->ratingCode; }

    /**
     * @return MarketUser
     */
    public function getRater() :MarketUser { return $this->rater; }


}