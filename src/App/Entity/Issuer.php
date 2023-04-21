<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;
use App\Entity\Data\CuBase;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Issuer")
 * @ORM\Table(name="Issuer")
 *
 */
class Issuer extends AnnotationMappings
{
    use CreatePropertiesArrayTrait;

    protected array $ignoreDbProperties = [
        'deals' => null,
        'users' => null
    ];

    protected array $addUcIdToPropName = [];

    protected array $defaultValueProperties = [];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue *
     */
    protected int $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Deal", mappedBy="issuer")
     * @var PersistentCollection
     */
    protected $deals;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $issuerName='';

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MarketUser", mappedBy="issuer")
     * @var PersistentCollection
     */
    protected $users;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $approvedDate;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $equity=0.0;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $outstanding=0.0;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $mainContact='';

    /**
     * Each Issuer has One main contact - Unidirectional
     * @ORM\OneToOne(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * @var MarketUser
     */
    protected $contactId;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @var string
     */
    protected string $phone;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\CuBase", inversedBy="issuers")
     * @ORM\JoinColumn(name="cu_id", referencedColumnName="id", nullable=true)
     * @var CuBase
     */
    private $cuMain;

    function __construct()
    {
    }

    function addDeal(Deal $deal){ $this->getDeals()->add($deal); }

    function addUser(MarketUser $user){ $this->getUsers()->add($user); }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return PersistentCollection
     */
    public function getDeals() : PersistentCollection { return $this->deals; }

    /**
     * @return \DateTime
     */
    public function getApprovedDate() : \DateTime { return $this->approvedDate; }

    /**
     * @return MarketUser
     */
    public function getContactId(): MarketUser { return $this->contactId; }



    /**
     * @return PersistentCollection
     */
    public function getUsers():PersistentCollection { return $this->users; }

    /**
     * @return string
     */
    public function getIssuerName() :string { return $this->issuerName; }

    /**
     * @param string $issuerName
     */
    public function setIssuerName(string $issuerName):void { $this->issuerName = $issuerName; }

    /**
     * @param \DateTime $approvedDate
     */
    public function setApprovedDate(\DateTime $approvedDate):void { $this->approvedDate = $approvedDate; }

    /**
     * @return CuBase|null
     */
    public function getCuMain(): ?CuBase { return $this->cuMain; }

    /**
     * @param CuBase $cuMain
     */
    public function setCuMain(CuBase $cuMain): void { $this->cuMain = $cuMain; }



}