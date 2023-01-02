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
//use Doctrine\ORM\Mapping as ORM;

/**
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="DocType")
 */
class DocType extends AnnotationMappings
{
    use CreatePropertiesArrayTrait;

    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $type;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\DealFile", mappedBy="docType")
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