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
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Rating", mappedBy="ratingCode")
     * @var ArrayCollection
     */
    protected $ratings;

    /** @ORM\Column(type="string", nullable=false)   */
    protected $meaning;

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
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return ArrayCollection
     */
    public function getRatings() { return $this->ratings; }

    /**
     * @return mixed
     */
    public function getMeaning() { return $this->meaning; }

}