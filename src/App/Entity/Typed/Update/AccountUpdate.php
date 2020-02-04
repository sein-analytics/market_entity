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
 * @ChangeTrackingPolicy("NOTIFY")
 *
 */
class AccountUpdate extends AbstractTypeUpdate
{

    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue */
    protected $id;

    /**
     * @var \App\Entity\Typed\Account $account
     * @ORM\ManyToOne(targetEntity="\App\Entity\Typed\Account", inversedBy="updates", fetch="EAGER") **/
    protected $account;

    /**
     * @var \App\Entity\Period $period
     * @ORM\ManyToOne(targetEntity="App\Entity\Period", inversedBy="accounts", fetch="EAGER") **/
    protected $period;

    /**
     * @var double $beginningBalance
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $beginningBalance;

    /**
     * @var double $accountWithdrawals
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $accountWithdrawals;

    /**
     * @var double $accountDeposits
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $accountDeposits;

    /**
     * @var double $endingBalance
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $endingBalance;

    /**
     * @var double $shortfall
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $shortfall;

    /**
     * @var double $requiredAmount
     * @ORM\Column(type = "decimal", precision=14, scale=2, nullable=true) **/
    public $requiredAmount;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Account $account
     */
    public function getAccount() {
        return $this->account;
    }

    public function getPeriod() {
        return $this->period;
    }

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period) {
        $this->implementChange($this,'period', $this->period, $period);
    }

    /**
     * @return number $beginningBalance
     */
    public function getBeginningBalance() {
        return $this->beginningBalance;
    }

    /**
     * @return number $accountWithdrawals
     */
    public function getAccountWithdrawals() {
        return $this->accountWithdrawals;
    }

    /**
     * @return number $accountDeposits
     */
    public function getAccountDeposits() {
        return $this->accountDeposits;
    }

    /**
     * @return number $endingBalance
     */
    public function getEndingBalance() {
        return $this->endingBalance;
    }

    /**
     * @return number $shortfall
     */
    public function getShortfall() {
        return $this->shortfall;
    }

    /**
     * @return number $requiredAmount
     */
    public function getRequiredAmount() {
        return $this->requiredAmount;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account) {
        $this->implementChange($this,'account', $this->account, $account);
    }

    /**
     * @param double $beginningBalance
     */
    public function setBeginningBalance($beginningBalance) {
        $this->implementChange($this,'beginningBalance', $this->beginningBalance, $beginningBalance);
    }

    /**
     * @param double $accountWithdrawals
     */
    public function setAccountWithdrawals($accountWithdrawals) {
        $this->implementChange($this,'accountWithdrawals', $this->accountWithdrawals, $accountWithdrawals);
    }

    /**
     * @param double $accountDeposits
     */
    public function setAccountDeposits($accountDeposits) {
        $this->implementChange($this,'accountDeposits', $this->accountDeposits, $accountDeposits);
    }

    /**
     * @param double $endingBalance
     */
    public function setEndingBalance($endingBalance) {
        $this->implementChange($this,'endingBalance', $this->endingBalance, $endingBalance);
    }

    /**
     * @param double $shortfall
     */
    public function setShortfall($shortfall) {
        $this->implementChange($this,'shortfall', $this->shortfall, $shortfall);
    }

    /**
     * @param number $requiredAmount
     */
    public function setRequiredAmount($requiredAmount) {
        $this->implementChange($this,'requiredAmount', $this->requiredAmount, $requiredAmount);
    }
    
}