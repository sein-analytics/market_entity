<?php

namespace App\Entity\Loan;
use App\Entity\DomainObject;
use App\Entity\Loan;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\Loan\PropertyAttribute")
 * @ORM\Table(name="PropertyAttribute")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class PropertyAttribute extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\Column (type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Loan", inversedBy="propertyAttribute")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id", nullable=false)
     * @var Loan
     */
    protected $loan;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $address;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array | null
     **/
    protected ?array $reportLinks;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array | null
     **/
    protected ?array $priceComps;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array | null
     **/
    protected ?array $propertyPictures;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var array | null
     **/
    protected ?array $propertyLinks;

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

}