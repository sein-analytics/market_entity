<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/15/18
 * Time: 3:47 PM
 */

namespace App\Entity;

use App\Entity\Rating;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="UserRating")
 */
class RatingCode 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="ratingCode")
     * @var PersistentCollection|ArrayCollection|null
     */
    protected $ratings;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $meaning;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
    }

    public function addRating(Rating $rating)
    {
        if ($this->ratings->contains($rating))
            return;
        $this->ratings->add($rating);
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return PersistentCollection|ArrayCollection|null
     */
    public function getRatings():PersistentCollection|ArrayCollection|null
    { return $this->ratings; }

    /**
     * @return string
     */
    public function getMeaning():string { return $this->meaning; }

}