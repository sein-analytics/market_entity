<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed\Update;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Period;
use App\Entity\Typed\Account;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;
/**
 *
 * @ORM\Entity
 * @ORM\Table(name="AccountUpdate")
 * @ORM\ChangeTrackingPolicy("NOTIFY")
 *
 */
class AccountUpdate extends AbstractTypeUpdate
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @var Account $account
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\Account", inversedBy="updates", fetch="EAGER")
     **/
    protected $account;

    /**
     * @var Period $period
     * @ORM\ManyToOne(targetEntity="App\Entity\Period", inversedBy="accounts", fetch="EAGER")
     **/
    protected $period;

    /**
     * @var float|null $beginningBalance
     * @ORM\Column(type = "float", precision=14, scale=2, nullable=true)
     **/
    public float|null $beginningBalance;

    /**
     * @var float|null $accountWithdrawals
     * @ORM\Column(type = "float", precision=14, scale=2, nullable=true)
     **/
    public float|null $accountWithdrawals;

    /**
     * @var float|null $accountDeposits
     * @ORM\Column(type = "float", precision=14, scale=2, nullable=true)
     **/
    public float|null $accountDeposits;

    /**
     * @var float|null $endingBalance
     * @ORM\Column(type = "float", precision=14, scale=2, nullable=true)
     **/
    public float|null $endingBalance;

    /**
     * @var float|null $shortfall
     * @ORM\Column(type = "float", precision=14, scale=2, nullable=true)
     **/
    public float|null $shortfall;

    /**
     * @var float|null $requiredAmount
     * @ORM\Column(type = "float", precision=14, scale=2, nullable=true)
     **/
    public float|null $requiredAmount;

    /**
     * @return mixed
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return Account $account
     */
    public function getAccount():Account {
        return $this->account;
    }

    /**
     * @return Period
     */
    public function getPeriod():Period {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period):void {
        $this->implementChange($this,'period', $this->period, $period);
    }

    /**
     * @return float|null $beginningBalance
     */
    public function getBeginningBalance():?float {
        return $this->beginningBalance;
    }

    /**
     * @return float|null $accountWithdrawals
     */
    public function getAccountWithdrawals():?float {
        return $this->accountWithdrawals;
    }

    /**
     * @return float|null $accountDeposits
     */
    public function getAccountDeposits():?float {
        return $this->accountDeposits;
    }

    /**
     * @return float|null $endingBalance
     */
    public function getEndingBalance():?float {
        return $this->endingBalance;
    }

    /**
     * @return float|null $shortfall
     */
    public function getShortfall():?float {
        return $this->shortfall;
    }

    /**
     * @return float|null $requiredAmount
     */
    public function getRequiredAmount():?float {
        return $this->requiredAmount;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account):void {
        $this->implementChange($this,'account', $this->account, $account);
    }

    /**
     * @param float $beginningBalance
     */
    public function setBeginningBalance(float $beginningBalance):void {
        $this->implementChange($this,'beginningBalance', $this->beginningBalance, $beginningBalance);
    }

    /**
     * @param float $accountWithdrawals
     */
    public function setAccountWithdrawals(float $accountWithdrawals):void {
        $this->implementChange($this,'accountWithdrawals', $this->accountWithdrawals, $accountWithdrawals);
    }

    /**
     * @param float $accountDeposits
     */
    public function setAccountDeposits(float $accountDeposits):void {
        $this->implementChange($this,'accountDeposits', $this->accountDeposits, $accountDeposits);
    }

    /**
     * @param float  $endingBalance
     */
    public function setEndingBalance(float $endingBalance):void {
        $this->implementChange($this,'endingBalance', $this->endingBalance, $endingBalance);
    }

    /**
     * @param float $shortfall
     */
    public function setShortfall(float $shortfall):void {
        $this->implementChange($this,'shortfall', $this->shortfall, $shortfall);
    }

    /**
     * @param float $requiredAmount
     */
    public function setRequiredAmount(float $requiredAmount):void {
        $this->implementChange($this,'requiredAmount', $this->requiredAmount, $requiredAmount);
    }
    
}