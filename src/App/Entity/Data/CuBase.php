<?php


namespace App\Entity\Data;

use \App\Entity\Data\CuBaseData;
use \App\Entity\Issuer;
use App\Entity\Data\CunaRegion;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Data\State;
use App\Entity\Data\CunaType;
use Doctrine\ORM\PersistentCollection;

#[ORM\Table(name: 'CuBase')]
#[ORM\Entity]
class CuBase
{
    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    /**
     * @var int
     **/
    #[ORM\Column(type: 'integer')]
    protected int $charterNum;

    /**
     * @var int
     **/
    #[ORM\Column(type: 'integer')]
    protected int $ncuaId;

    /**
     * @var string
     **/
    #[ORM\Column(type: 'string')]
    protected string $name;

    /**
     * @var string
     **/
    #[ORM\Column(type: 'string')]
    protected string $address;

    /**
     * @var string
     **/
    #[ORM\Column(type: 'string')]
    protected string $city;

    /**
     * @var State
     **/
    #[ORM\JoinColumn(name: 'state_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity:  State::class)]
    protected $state;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $zip;

    #[ORM\Column(type: 'boolean', nullable: false)]
    protected bool $isLowIncDes;

    /**
     * @var CunaType
     **/
    #[ORM\JoinColumn(name: 'type_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity:  CunaType::class)]
    protected $type;

    /**
     * @var CunaRegion
     **/
    #[ORM\JoinColumn(name: 'region_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity:  CunaRegion::class)]
    protected $region;

    /**
     * @var PersistentCollection
     **/
    #[ORM\OneToMany(targetEntity: CuBaseData::class, mappedBy: 'cuBase')]
    protected $cuData;

    #[ORM\OneToMany(targetEntity: Issuer::class, mappedBy: 'cuMain')]
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