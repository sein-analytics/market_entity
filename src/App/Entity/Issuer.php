<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Facades\App;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Issuer")
 *
 */
class Issuer
{
    use NotifyChangeTrait, CreatePropertiesArrayTrait;

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\OneToMany(targetEntity="App\Entity\Deal", mappedBy="issuer")   */
    protected $deals;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $issuerName;

    /** @ORM\OneToMany(targetEntity="App\Entity\MarketUser", mappedBy="issuer")   */
    protected $users;

    /** @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     **/
    protected $approvedDate;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $equity;

    /** @ORM\Column(type="decimal", precision=14, scale=2, nullable=false) **/
    protected $outstanding;

    /** @ORM\Column(type="string", nullable=false) **/
    protected $mainContact;

    /** @ORM\Column(type="string", nullable=false, unique=true) **/
    protected $phone;

    function __construct()
    {
        $this->deals = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    function addDeal(Deal $deal){
        $this->deals->add($deal);
    }

    function addUser(MarketUser $user){
        $this->users->add($user);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDeals()
    {
        return $this->deals;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getIssuerName()
    {
        return $this->issuerName;
    }

    /**
     * @param mixed $issuerName
     */
    public function setIssuerName($issuerName)
    {
        $this->issuerName = $issuerName;
    }

    /**
     * @return \DateTime
     */
    public function getApprovedDate()
    {
        return $this->approvedDate;
    }

    /**
     * @param \DateTime $approvedDate
     */
    public function setApprovedDate(\DateTime $approvedDate)
    {
        $this->approvedDate = $approvedDate;
    }



}