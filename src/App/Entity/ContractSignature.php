<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'ContractSignature')]
#[ORM\Entity(repositoryClass: \App\Repository\ContractSignature::class)]
class ContractSignature
{

    /**
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected int $id;

    #[ORM\JoinColumn(name: 'sender_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class)]
    protected MarketUser $sender;

    #[ORM\JoinColumn(name: 'receiver_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  MarketUser::class)]
    protected ?MarketUser $receiver; 

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $senderSignature;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $receiverSignature;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $signatureId;

    #[ORM\JoinColumn(name: 'contract_status_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity:  ContractStatus::class)]
    protected ContractStatus $contractStatus;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $publicId;

    function __construct()
    {
        $this->sender = new MarketUser();
        $this->receiver = new MarketUser();
    }

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return MarketUser
     */
    public function getUser():MarketUser { return $this->sender; }

    /**
     * @param MarketUser $sender
     */
    public function setUser(MarketUser $sender):void { $this->sender = $sender; }

    /**
     * @return MarketUser|null
     */
    public function getReceiver():MarketUser|null { return $this->receiver; }

    /**
     * @param MarketUser $sender
     */
    public function setReceiver(MarketUser $receiver):void { $this->receiver = $receiver; }

    /**
     * @return string|null
     */
    public function getSenderSignature():string|null { return $this->senderSignature; }

    /**
     * @param string
     */
    public function setSenderSignature(string $senderSignature):void { $this->senderSignature = $senderSignature; }
    
    /**
     * @return string|null
     */
    public function getReceiverSignature():string|null { return $this->receiverSignature; }

    /**
     * @param string
     */
    public function setReceiverSignature(string $receiverSignature):void { $this->receiverSignature = $receiverSignature; }
    
    /**
     * @return string|null
     */
    public function getSignatureId():string|null { return $this->signatureId; }

    /**
     * @param string
     */
    public function setSignatureId(string $signatureId):void { $this->signatureId = $signatureId; }
    
    /**
     * @return ContractStatus
     */
    public function getContractStatus():ContractStatus { return $this->contractStatus; }

    /**
     * @param ContractStatus $contractStatus
     */
    public function setContractStatus(ContractStatus $contractStatus):void { $this->contractStatus = $contractStatus; }

    /**
     * @return string|null
     */
    public function getPublicId():string|null { return $this->publicId; }

    /**
     * @param string
     */
    public function setPublicId(string $publicId):void { $this->publicId = $publicId; }

}