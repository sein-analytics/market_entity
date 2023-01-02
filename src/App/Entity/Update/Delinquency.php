<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/16/16
 * Time: 1:34 PM
 */

namespace App\Entity\Update;

use App\Entity\DomainObject;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
/**
 * @ORM\Entity
 * @ORM\Table(name="Delinquency")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class Delinquency extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer") *
     */
    protected int $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Update\PoolUpdate", mappedBy="delinquency")
     * @var PoolUpdate
     */
    protected $poolUpdate;

    /**
     * Current Period's balance that is 30-60 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq30Balance;

    /**
     * Current Period's number of loans that are 30-60 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq30Loans;

    /**
     * Current Period's balance that is 61-90 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq60Balance;

    /**
     * Current Period's number of loans 61-90 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq60Loans;

    /**
     * Current Period's balance that is 91-120 or more days past-due (depends on trustee reporting)
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq90Balance;

    /**
     * Current Period's number of loans 91-120 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq90Loans;

    /**
     * Current Period's loan balance that is 120 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq120Balance;

    /**
     * Current Period's number of loans 120 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq120Loans;

    /**
     * Current Period's loan balance that is 150 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq150Balance;

    /**
     * Current Period's number of loans 150 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq150Loans;

    /**
     * Current Period's loan balance that is 180 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq180Balance;

    /**
     * Current Period's number of loans 180 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $dq180Loans;

    /**
     * Current Period's loan balance that is in reo
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $reoLoans;

    /**
     * Current Period's number of loans in reo
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $reoBalance;

    /**
     * Current Period's loan balance that is in foreclosure
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $foreclosureBalance;

    /**
     * Current Period's number of loans in foreclosure
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $foreclosureLoans;

    /**
     * Current Period's loan balance that is 180 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $bankruptcyBalance;

    /**
     * Current Period's number of loans 180 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     * @var ?float
     **/
    protected ?float $bankruptcyLoans;

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return ?PoolUpdate
     */
    public function getPoolUpdate():?PoolUpdate
    {
        return $this->poolUpdate;
    }

    /**
     * @param PoolUpdate $poolUpdate
     */
    public function setPoolUpdate(PoolUpdate $poolUpdate):void
    {
        $this->implementChange($this,'poolUpdate', $this->poolUpdate, $poolUpdate);
    }

    /**
     * @return ?float
     */
    public function getDq30Balance():?float
    {
        return $this->dq30Balance;
    }

    /**
     * @param float $dq30Balance
     */
    public function setDq30Balance(float $dq30Balance):void
    {
        $this->implementChange($this,'dq30Balance', $this->dq30Balance, $dq30Balance);
    }

    /**
     * @return ?float
     */
    public function getDq30Loans():?float
    {
        return $this->dq30Loans;
    }

    /**
     * @param float $dq30Loans
     */
    public function setDq30Loans(float $dq30Loans):void
    {
        $this->implementChange($this,'dq30Loans', $this->dq30Loans, $dq30Loans);
    }

    /**
     * @return ?float
     */
    public function getDq60Balance():?float
    {
        return $this->dq60Balance;
    }

    /**
     * @param float $dq60Balance
     */
    public function setDq60Balance(float $dq60Balance):void
    {
        $this->implementChange($this,'dq60Balance', $this->dq60Balance, $dq60Balance);
    }

    /**
     * @return ?float
     */
    public function getDq60Loans():?float
    {
        return $this->dq60Loans;
    }

    /**
     * @param float $dq60Loans
     */
    public function setDq60Loans(float $dq60Loans):void
    {
        $this->implementChange($this,'dq60Loans', $this->dq60Loans, $dq60Loans);
    }

    /**
     * @return ?float
     */
    public function getDq90Balance():?float
    {
        return $this->dq90Balance;
    }

    /**
     * @param float $dq90Balance
     */
    public function setDq90Balance(float $dq90Balance):void
    {
        $this->implementChange($this,'dq90Balance', $this->dq90Balance, $dq90Balance);
    }

    /**
     * @return ?float
     */
    public function getDq90Loans():?float
    {
        return $this->dq90Loans;
    }

    /**
     * @param float $dq90Loans
     */
    public function setDq90Loans(float $dq90Loans):void
    {
        $this->implementChange($this,'dq90Loans', $this->dq90Loans, $dq90Loans);
    }

    /**
     * @return ?float
     */
    public function getDq120Balance():?float
    {
        return $this->dq120Balance;
    }

    /**
     * @param float $dq120Balance
     */
    public function setDq120Balance(float $dq120Balance):void
    {
        $this->implementChange($this,'dq120Balance', $this->dq120Balance, $dq120Balance);
    }

    /**
     * @return ?float
     */
    public function getDq120Loans():?float
    {
        return $this->dq120Loans;
    }

    /**
     * @param float $dq120Loans
     */
    public function setDq120Loans(float $dq120Loans):void
    {
        $this->implementChange($this,'dq120Loans', $this->dq120Loans, $dq120Loans);
    }

    /**
     * @return ?float
     */
    public function getDq150Balance():?float
    {
        return $this->dq150Balance;
    }

    /**
     * @param float $dq150Balance
     */
    public function setDq150Balance(float $dq150Balance):void
    {
        $this->implementChange($this,'dq150Balance', $this->dq150Balance, $dq150Balance);
    }

    /**
     * @return ?float
     */
    public function getDq150Loans():?float
    {
        return $this->dq150Loans;
    }

    /**
     * @param float $dq150Loans
     */
    public function setDq150Loans(float $dq150Loans):void
    {
        $this->implementChange($this,'dq150Loans', $this->dq150Loans, $dq150Loans);
    }

    /**
     * @return ?float
     */
    public function getDq180Balance():?float
    {
        return $this->dq180Balance;
    }

    /**
     * @param float $dq180Balance
     */
    public function setDq180Balance(float $dq180Balance):void
    {
        $this->implementChange($this,'dq180Balance', $this->dq180Balance, $dq180Balance);
    }

    /**
     * @return ?float
     */
    public function getDq180Loans():?float
    {
        return $this->dq180Loans;
    }

    /**
     * @param float $dq180Loans
     */
    public function setDq180Loans(float $dq180Loans):void
    {
        $this->implementChange($this,'dq180Loans', $this->dq180Loans, $dq180Loans);
    }

    /**
     * @return ?float
     */
    public function getReoLoans():?float
    {
        return $this->reoLoans;
    }

    /**
     * @param float $reoLoans
     */
    public function setReoLoans(float $reoLoans):void
    {
        $this->implementChange($this,'reoLoans', $this->reoLoans, $reoLoans);
    }

    /**
     * @return ?float
     */
    public function getReoBalance():?float
    {
        return $this->reoBalance;
    }

    /**
     * @param float $reoBalance
     */
    public function setReoBalance(float $reoBalance):void
    {
        $this->implementChange($this,'reoBalance', $this->reoBalance, $reoBalance);
    }

    /**
     * @return ?float
     */
    public function getForeclosureBalance():?float
    {
        return $this->foreclosureBalance;
    }

    /**
     * @param float $foreclosureBalance
     */
    public function setForeclosureBalance(float $foreclosureBalance):void
    {
        $this->implementChange($this,'foreclosureBalance', $this->foreclosureBalance, $foreclosureBalance);
    }

    /**
     * @return ?float
     */
    public function getForeclosureLoans():?float
    {
        return $this->foreclosureLoans;
    }

    /**
     * @param float $foreclosureLoans
     */
    public function setForeclosureLoans(float $foreclosureLoans):void
    {
        $this->implementChange($this,'foreclosureLoans', $this->foreclosureLoans, $foreclosureLoans);
    }

    /**
     * @return ?float
     */
    public function getBankruptcyBalance():?float
    {
        return $this->bankruptcyBalance;
    }

    /**
     * @param float $bankruptcyBalance
     */
    public function setBankruptcyBalance(float $bankruptcyBalance):void
    {
        $this->implementChange($this,'bankruptcyBalance', $this->bankruptcyBalance, $bankruptcyBalance);
    }

    /**
     * @return ?float
     */
    public function getBankruptcyLoans():?float
    {
        return $this->bankruptcyLoans;
    }

    /**
     * @param float $bankruptcyLoans
     */
    public function setBankruptcyLoans(float $bankruptcyLoans):void
    {
        $this->implementChange($this,'bankruptcyLoans', $this->bankruptcyLoans, $bankruptcyLoans);
    }

}