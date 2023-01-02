<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Samuel Belu-John
 *
 * @ORM\Entity
 * @ORM\Table(name="AccountType")
 */
class AccountType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     */
    protected string $label;

    /**
     * @ORM\Column(type="string")
     */
    protected string $slug;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Typed\Account", mappedBy="type")
     * @var Account
     */
    protected $accounts;

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel():string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label):void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getSlug():string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug):void
    {
        $this->slug = $slug;
    }

    /**
     * @return Account
     */
    public function getAccounts(): Account
    {
        return $this->accounts;
    }

    /**
     * @param Account $accounts
     */
    public function setAccounts(Account $accounts):void
    {
        $this->accounts = $accounts;
    }


}