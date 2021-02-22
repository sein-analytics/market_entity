<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Issuer")
 * @ORM\Table(name="Issuer")
 *
 */
class Issuer
{
    use CreatePropertiesArrayTrait;

    protected $ignoreDbProperties = [
        'deals' => null,
        'users' => null
    ];

    protected $addUcIdToPropName = [];

    protected $defaultValueProperties = [];

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\OneToMany(targetEntity="App\Entity\Deal", mappedBy="issuer")
     * @var PersistentCollection
     */
    protected $deals;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $issuerName;

    /** @ORM\OneToMany(targetEntity="App\Entity\MarketUser", mappedBy="issuer")
     * @var PersistentCollection
     */
    protected $users;

    /** @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $approvedDate;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $equity;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $outstanding;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $mainContact;

    /**
     * Each Issuer has One main contact - Unidirectional
     * @ORM\OneToOne(targetEntity="\App\Entity\MarketUser")
     * @JoinColumn(name="contact_id", referencedColumnName="id")
     * @var MarketUser
     */
    protected $contactId;

    /** @ORM\Column(type="string", nullable=false, unique=true) **/
    protected $phone;

    function __construct()
    {
    }

    function addDeal(Deal $deal){ $this->getDeals()->add($deal); }

    function addUser(MarketUser $user){ $this->getUsers()->add($user); }

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

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
    public function getUsers() { return $this->users; }

    /**
     * @return string
     */
    public function getIssuerName() :string { return $this->issuerName; }

    /**
     * @param string $issuerName
     */
    public function setIssuerName(string $issuerName) { $this->issuerName = $issuerName; }

    /**
     * @param \DateTime $approvedDate
     */
    public function setApprovedDate(\DateTime $approvedDate) { $this->approvedDate = $approvedDate; }



}