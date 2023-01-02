<?php


namespace App\Entity\Data;

use App\Entity\AnnotationMappings;
use App\Entity\Data\CunaRegion;
//use Doctrine\ORM\Mapping as ORM;
use App\Entity\Data\State;
use App\Entity\Data\CunaType;
use Doctrine\ORM\PersistentCollection;

/**
 * \Doctrine\ORM\Mapping\Entity()
 * \Doctrine\ORM\Mapping\Table(name="CuBase")
 */
class CuBase extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * @var int
     **/
    protected int $charterNum;

    /**
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * @var int
     **/
    protected int $ncuaId;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string")
     * @var string
     **/
    protected string $name;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string")
     * @var string
     **/
    protected string $address;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string")
     * @var string
     **/
    protected string $city;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Data\State")
     * \Doctrine\ORM\Mapping\JoinColumn(name="state_id", referencedColumnName="id")
     * @var State
     **/
    protected $state;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $zip;

    /**
     * \Doctrine\ORM\Mapping\Column(type="boolean", nullable=false)
     */
    protected bool $isLowIncDes;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Data\CunaType")
     * \Doctrine\ORM\Mapping\JoinColumn(name="type_id", referencedColumnName="id")
     * @var CunaType
     **/
    protected $type;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Data\CunaRegion")
     * \Doctrine\ORM\Mapping\JoinColumn(name="region_id", referencedColumnName="id")
     * @var CunaRegion
     **/
    protected $region;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Data\CuBaseData", mappedBy="cuBase")
     * @var PersistentCollection
     **/
    protected $cuData;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Issuer", mappedBy="cuMain")
     */
    protected $issuers;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getName(): string { return $this->name; }

    /**
     * @return string
     */
    public function getAddress(): string { return $this->address; }

    /**
     * @return string
     */
    public function getCity(): string { return $this->city; }

    /**
     * @return State
     */
    public function getState(): State { return $this->state; }

    /**
     * @return string
     */
    public function getZip():string { return $this->zip; }

    /**
     * @return CunaType
     */
    public function getType(): CunaType { return $this->type; }

    /**
     * @return CunaRegion
     */
    public function getRegion(): CunaRegion { return $this->region; }

    /**
     * @return bool|int
     */
    public function getIsLowIncDes():bool|int { return $this->isLowIncDes; }


}