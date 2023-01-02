<?php


namespace App\Entity\Data;

use App\Entity\Data\CunaRegion;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Data\State;
use App\Entity\Data\CunaType;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="CuBase")
 */
class CuBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected $id;

    /**
     * @ORM\Column(type="integer")
     * @var int
     **/
    protected int $charterNum;

    /**
     * @ORM\Column(type="integer")
     * @var int
     **/
    protected int $ncuaId;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected string $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected string $address;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected string $city;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     * @var State
     **/
    protected $state;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $zip;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected bool $isLowIncDes;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\CunaType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @var CunaType
     **/
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\CunaRegion")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     * @var CunaRegion
     **/
    protected $region;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Data\CuBaseData", mappedBy="cuBase")
     * @var PersistentCollection
     **/
    protected $cuData;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Issuer", mappedBy="cuMain")
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