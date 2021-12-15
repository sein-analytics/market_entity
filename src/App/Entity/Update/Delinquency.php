<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/16/16
 * Time: 1:34 PM
 */

namespace App\Entity\Update;

use App\Entity\DomainObject;
use App\Entity\NotifyChangeTrait;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
use App\Entity\Update\PoolUpdate;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Delinquency")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 */
class Delinquency extends DomainObject
{
    use CreatePropertiesArrayTrait;

    /** @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer") **/
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\App\Entity\Update\PoolUpdate", mappedBy="delinquency")
     * @var \App\Entity\Update\PoolUpdate
     */
    protected $poolUpdate;

    /**
     * Current Period's balance that is 30-60 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $dq30Balance;

    /**
     * Current Period's number of loans that are 30-60 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     **/
    protected $dq30Loans;

    /**
     * Current Period's balance that is 61-90 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $dq60Balance;

    /**
     * Current Period's number of loans 61-90 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     **/
    protected $dq60Loans;

    /**
     * Current Period's balance that is 91-120 or more days past-due (depends on trustee reporting)
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $dq90Balance;

    /**
     * Current Period's number of loans 91-120 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     **/
    protected $dq90Loans;

    /**
     * Current Period's loan balance that is 120 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $dq120Balance;

    /**
     * Current Period's number of loans 120 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     **/
    protected $dq120Loans;

    /**
     * Current Period's loan balance that is 150 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $dq150Balance;

    /**
     * Current Period's number of loans 150 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     **/
    protected $dq150Loans;

    /**
     * Current Period's loan balance that is 180 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $dq180Balance;

    /**
     * Current Period's number of loans 180 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     **/
    protected $dq180Loans;

    /**
     * Current Period's loan balance that is in reo
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $reoLoans;

    /**
     * Current Period's number of loans in reo
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     **/
    protected $reoBalance;

    /**
     * Current Period's loan balance that is in foreclosure
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $foreclosureBalance;

    /**
     * Current Period's number of loans in foreclosure
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     **/
    protected $foreclosureLoans;

    /**
     * Current Period's loan balance that is 180 days past-due
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     **/
    protected $bankruptcyBalance;

    /**
     * Current Period's number of loans 180 days past-due
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     **/
    protected $bankruptcyLoans;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \App\Entity\Update\PoolUpdate
     */
    public function getPoolUpdate()
    {
        return $this->poolUpdate;
    }

    /**
     * @param \App\Entity\Update\PoolUpdate $poolUpdate
     */
    public function setPoolUpdate(PoolUpdate $poolUpdate)
    {
        $this->implementChange($this,'poolUpdate', $this->poolUpdate, $poolUpdate);
    }

    /**
     * @return mixed
     */
    public function getDq30Balance()
    {
        return $this->dq30Balance;
    }

    /**
     * @param mixed $dq30Balance
     */
    public function setDq30Balance($dq30Balance)
    {
        $this->implementChange($this,'dq30Balance', $this->dq30Balance, $dq30Balance);
    }

    /**
     * @return mixed
     */
    public function getDq30Loans()
    {
        return $this->dq30Loans;
    }

    /**
     * @param mixed $dq30Loans
     */
    public function setDq30Loans($dq30Loans)
    {
        $this->implementChange($this,'dq30Loans', $this->dq30Loans, $dq30Loans);
    }

    /**
     * @return mixed
     */
    public function getDq60Balance()
    {
        return $this->dq60Balance;
    }

    /**
     * @param mixed $dq60Balance
     */
    public function setDq60Balance($dq60Balance)
    {
        $this->implementChange($this,'dq60Balance', $this->dq60Balance, $dq60Balance);
    }

    /**
     * @return mixed
     */
    public function getDq60Loans()
    {
        return $this->dq60Loans;
    }

    /**
     * @param mixed $dq60Loans
     */
    public function setDq60Loans($dq60Loans)
    {
        $this->implementChange($this,'dq60Loans', $this->dq60Loans, $dq60Loans);
    }

    /**
     * @return mixed
     */
    public function getDq90Balance()
    {
        return $this->dq90Balance;
    }

    /**
     * @param mixed $dq90Balance
     */
    public function setDq90Balance($dq90Balance)
    {
        $this->implementChange($this,'dq90Balance', $this->dq90Balance, $dq90Balance);
    }

    /**
     * @return mixed
     */
    public function getDq90Loans()
    {
        return $this->dq90Loans;
    }

    /**
     * @param mixed $dq90Loans
     */
    public function setDq90Loans($dq90Loans)
    {
        $this->implementChange($this,'dq90Loans', $this->dq90Loans, $dq90Loans);
    }

    /**
     * @return mixed
     */
    public function getDq120Balance()
    {
        return $this->dq120Balance;
    }

    /**
     * @param mixed $dq120Balance
     */
    public function setDq120Balance($dq120Balance)
    {
        $this->implementChange($this,'dq120Balance', $this->dq120Balance, $dq120Balance);
    }

    /**
     * @return mixed
     */
    public function getDq120Loans()
    {
        return $this->dq120Loans;
    }

    /**
     * @param mixed $dq120Loans
     */
    public function setDq120Loans($dq120Loans)
    {
        $this->implementChange($this,'dq120Loans', $this->dq120Loans, $dq120Loans);
    }

    /**
     * @return mixed
     */
    public function getDq150Balance()
    {
        return $this->dq150Balance;
    }

    /**
     * @param mixed $dq150Balance
     */
    public function setDq150Balance($dq150Balance)
    {
        $this->implementChange($this,'dq150Balance', $this->dq150Balance, $dq150Balance);
    }

    /**
     * @return mixed
     */
    public function getDq150Loans()
    {
        return $this->dq150Loans;
    }

    /**
     * @param mixed $dq150Loans
     */
    public function setDq150Loans($dq150Loans)
    {
        $this->implementChange($this,'dq150Loans', $this->dq150Loans, $dq150Loans);
    }

    /**
     * @return mixed
     */
    public function getDq180Balance()
    {
        return $this->dq180Balance;
    }

    /**
     * @param mixed $dq180Balance
     */
    public function setDq180Balance($dq180Balance)
    {
        $this->implementChange($this,'dq180Balance', $this->dq180Balance, $dq180Balance);
    }

    /**
     * @return mixed
     */
    public function getDq180Loans()
    {
        return $this->dq180Loans;
    }

    /**
     * @param mixed $dq180Loans
     */
    public function setDq180Loans($dq180Loans)
    {
        $this->implementChange($this,'dq180Loans', $this->dq180Loans, $dq180Loans);
    }

    /**
     * @return mixed
     */
    public function getReoLoans()
    {
        return $this->reoLoans;
    }

    /**
     * @param mixed $reoLoans
     */
    public function setReoLoans($reoLoans)
    {
        $this->implementChange($this,'reoLoans', $this->reoLoans, $reoLoans);
    }

    /**
     * @return mixed
     */
    public function getReoBalance()
    {
        return $this->reoBalance;
    }

    /**
     * @param mixed $reoBalance
     */
    public function setReoBalance($reoBalance)
    {
        $this->implementChange($this,'reoBalance', $this->reoBalance, $reoBalance);
    }

    /**
     * @return mixed
     */
    public function getForeclosureBalance()
    {
        return $this->foreclosureBalance;
    }

    /**
     * @param mixed $foreclosureBalance
     */
    public function setForeclosureBalance($foreclosureBalance)
    {
        $this->implementChange($this,'foreclosureBalance', $this->foreclosureBalance, $foreclosureBalance);
    }

    /**
     * @return mixed
     */
    public function getForeclosureLoans()
    {
        return $this->foreclosureLoans;
    }

    /**
     * @param mixed $foreclosureLoans
     */
    public function setForeclosureLoans($foreclosureLoans)
    {
        $this->implementChange($this,'foreclosureLoans', $this->foreclosureLoans, $foreclosureLoans);
    }

    /**
     * @return mixed
     */
    public function getBankruptcyBalance()
    {
        return $this->bankruptcyBalance;
    }

    /**
     * @param mixed $bankruptcyBalance
     */
    public function setBankruptcyBalance($bankruptcyBalance)
    {
        $this->implementChange($this,'bankruptcyBalance', $this->bankruptcyBalance, $bankruptcyBalance);
    }

    /**
     * @return mixed
     */
    public function getBankruptcyLoans()
    {
        return $this->bankruptcyLoans;
    }

    /**
     * @param mixed $bankruptcyLoans
     */
    public function setBankruptcyLoans($bankruptcyLoans)
    {
        $this->implementChange($this,'bankruptcyLoans', $this->bankruptcyLoans, $bankruptcyLoans);
    }

}