<?php

namespace App\Entity\Loan;
use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
 
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'PropertyAttribute')]
#[ORM\Entity(repositoryClass: \App\Repository\Loan\PropertyAttribute::class)]
 
class PropertyAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @var int
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var Loan
     */
    #[ORM\JoinColumn(name: 'loan_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\OneToOne(targetEntity:  Loan::class, inversedBy: 'propertyAttribute')]
    protected $loan;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected string $address;

    /**
     * @var array | null
     **/
    #[ORM\Column(type: 'json', nullable: true)]
    protected ?array $reportLinks;

    /**
     * @var array | null
     **/
    #[ORM\Column(type: 'json', nullable: true)]
    protected ?array $priceComps;

    /**
     * @var array | null
     **/
    #[ORM\Column(type: 'json', nullable: true)]
    protected ?array $propertyPictures;

    /**
     * @var array | null
     **/
    #[ORM\Column(type: 'json', nullable: true)]
    protected ?array $propertyLinks;

    /**
     * @var float | null
     **/
    #[ORM\Column(type: 'float', nullable: true)]
    protected ?float $sellerAsIsValue;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * @param Loan $loan
     * @return void
     */
    public function setLoan(Loan $loan): void
    {
        $this->loan = $loan;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return void
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return array|null
     */
    public function getReportLinks(): ?array
    {
        return $this->reportLinks;
    }

    /**
     * @param array|null $reportLinks
     * @return void
     */
    public function setReportLinks(?array $reportLinks): void
    {
        $this->reportLinks = $reportLinks;
    }

    /**
     * @return array|null
     */
    public function getPriceComps(): ?array
    {
        return $this->priceComps;
    }

    /**
     * @param array|null $priceComps
     * @return void
     */
    public function setPriceComps(?array $priceComps): void
    {
        $this->priceComps = $priceComps;
    }

    /**
     * @return array|null
     */
    public function getPropertyPictures(): ?array
    {
        return $this->propertyPictures;
    }

    /**
     * @param array|null $propertyPictures
     * @return void
     */
    public function setPropertyPictures(?array $propertyPictures): void
    {
        $this->propertyPictures = $propertyPictures;
    }

    /**
     * @return array|null
     */
    public function getPropertyLinks(): ?array
    {
        return $this->propertyLinks;
    }

    /**
     * @param array|null $propertyLinks
     * @return void
     */
    public function setPropertyLinks(?array $propertyLinks): void
    {
        $this->propertyLinks = $propertyLinks;
    }

    public function getSellerAsIsValue(): ?float
    {
        return $this->sellerAsIsValue;
    }

    public function setSellerAsIsValue(?float $sellerAsIsValue): void
    {
        $this->sellerAsIsValue = $sellerAsIsValue;
    }

}