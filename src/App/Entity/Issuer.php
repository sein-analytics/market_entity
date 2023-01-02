<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;
use App\Entity\Data\CuBase;
use App\Service\CreatePropertiesArrayTrait;
//use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\Issuer")
 * \Doctrine\ORM\Mapping\Table(name="Issuer")
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
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue *
     */
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\Deal", mappedBy="issuer")
     * @var PersistentCollection
     */
    protected $deals;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $issuerName='';

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="App\Entity\MarketUser", mappedBy="issuer")
     * @var PersistentCollection
     */
    protected $users;

    /**
     * \Doctrine\ORM\Mapping\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $approvedDate;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $equity=0.0;

    /**
     * \Doctrine\ORM\Mapping\Column(type="decimal", precision=14, scale=2, nullable=false)
     * @var float
     */
    protected float $outstanding=0.0;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
     * @var string
     */
    protected string $mainContact='';

    /**
     * Each Issuer has One main contact - Unidirectional
     * \Doctrine\ORM\Mapping\OneToOne(targetEntity="\App\Entity\MarketUser")
     * \Doctrine\ORM\Mapping\JoinColumn(name="contact_id", referencedColumnName="id")
     * @var MarketUser
     */
    protected $contactId;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false, unique=true)
     * @var string
     */
    protected string $phone;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="\App\Entity\Data\CuBase", inversedBy="issuers")
     * \Doctrine\ORM\Mapping\JoinColumn(name="cu_id", referencedColumnName="id", nullable=true)
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
    public function setIssuerName(string $issuerName):string { $this->issuerName = $issuerName; }

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