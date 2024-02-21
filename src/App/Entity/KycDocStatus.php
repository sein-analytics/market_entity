<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\KycDocStatus")
 * @ORM\Table(name="KycDocStatus")
 */
class KycDocStatus
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Issuer")
     * @ORM\JoinColumn(name="issuer_id", referencedColumnName="id", nullable=true)
     */
    protected Issuer $issuer;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\MarketUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    protected MarketUser $user;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\ContractStatus")
     * @ORM\JoinColumn(name="contract_status_id", referencedColumnName="id", nullable=true)
     */
    
    protected ?ContractStatus $contractStatus;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\KycDoc")
     * @ORM\JoinColumn(name="kyc_doc_id", referencedColumnName="id", nullable=false)
     */
    protected KycDoc $kycDoc;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var bool
     */
    protected bool $access = false;

    function __construct()
    {
        $this->issuer = new Issuer();
        $this->user = new MarketUser();
        $this->kycDoc = new KycDoc();
        $this->contractStatus = new ContractStatus();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return Issuer|null
     */
    public function getIssuer():Issuer|null { return $this->issuer; }

    /**
     * @param Issuer $issuer
     */
    public function setIssuer(Issuer $issuer):void { $this->issuer = $issuer; }
   
    /**
     * @return MarketUser|null
     */
    public function getUser():MarketUser|null { return $this->user; }

    /**
     * @param MarketUser $user
     */
    public function setUser(MarketUser $user):void { $this->user = $user; }

    /**
     * @return ContractStatus|null
     */
    public function getContractStatus():ContractStatus|null { return $this->contractStatus; }

    /**
     * @param ContractStatus $contractStatus
     */
    public function setContractStatus(ContractStatus $contractStatus):void { $this->contractStatus = $contractStatus; }
    
    /**
     * @return KycDoc
     */
    public function getKycDoc():KycDoc { return $this->kycDoc; }

    /**
     * @param KycDoc $kycDoc
     */
    public function setkKycDoc(KycDoc $kycDoc):void { $this->kycDoc = $kycDoc; }

    /**
     * @return bool
     */
    public function getAccess() :bool { return $this->access; }

    /**
     * @param bool $access
     */
    public function setAccess(bool $access):void { $this->access = $access; }

}