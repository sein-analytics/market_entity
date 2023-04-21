<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/4/17
 * Time: 4:51 PM
 */

namespace App\Entity;

use App\Service\CreatePropertiesArrayTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="DocType")
 */
class DocType 
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $type;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="docType")
     * @var ArrayCollection
     */
    protected $dealFiles;

    public function __construct()
    {
        $this->dealFiles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType():string
    {
        return $this->type;
    }

    /**
     * @return ArrayCollection
     */
    public function getDealFiles():ArrayCollection
    {
        return $this->dealFiles;
    }


}