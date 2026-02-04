<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;
use DateTime;
use App\Entity\Data\CuBase;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Table(name: 'Issuer')]
#[ORM\Entity(repositoryClass: \App\Repository\Issuer::class)]
class Issuer extends AnnotationMappings
{
    use CreatePropertiesArrayTrait;

    protected array $ignoreDbProperties = [
        'deals' => null,
        'users' => null
    ];

    protected array $addUcIdToPropName = [];

    protected array $defaultValueProperties = [];

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var PersistentCollection
     */
    #[ORM\OneToMany(targetEntity: Deal::class, mappedBy: 'issuer')]
    protected $deals;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $issuerName='';

    /**
     * @var PersistentCollection
     */
    #[ORM\OneToMany(targetEntity: MarketUser::class, mappedBy: 'issuer')]
    protected $users;

    /**
     * @var DateTime
     **/
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected DateTime $approvedDate;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: false)]
    protected float $equity=0.0;

    /**
     * @var float
     */
    #[ORM\Column(type: 'float', precision: 14, scale: 2, nullable: false)]
    protected float $outstanding=0.0;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $mainContact='';

    /**
     * Each Issuer has One main contact - Unidirectional
     * @var MarketUser
     */
    #[ORM\JoinColumn(name: 'contact_id', referencedColumnName: 'id')]
    #[ORM\OneToOne(targetEntity:  \App\Entity\MarketUser::class)]
    protected $contactId;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false, unique: true)]
    protected string $phone;

    /**
     * @var CuBase
     */
    #[ORM\JoinColumn(name: 'cu_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  \App\Entity\Data\CuBase::class, inversedBy: 'issuers')]
    private $cuMain;

    #[ORM\ManyToMany(targetEntity:  \App\Entity\KycDocument::class, inversedBy: 'accessIssuer')]
    protected $kycDocuments;

    function __construct()
    {
        $this->kycDocuments = new ArrayCollection();
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
     * @return DateTime
     */
    public function getApprovedDate() : DateTime { return $this->approvedDate; }

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
     * @param DateTime $approvedDate
     */
    public function setApprovedDate(DateTime $approvedDate):void { $this->approvedDate = $approvedDate; }

    /**
     * @return CuBase|null
     */
    public function getCuMain(): ?CuBase { return $this->cuMain; }

    /**
     * @param CuBase $cuMain
     */
    public function setCuMain(CuBase $cuMain): void { $this->cuMain = $cuMain; }

    public function addKycDocToIssuer(KycDocument $kycDoc):void
    {
        $this->kycDocuments->add($kycDoc);
    }

    public function getKycDocuments():ArrayCollection { return $this->kycDocuments; }

}