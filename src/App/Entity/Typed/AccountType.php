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
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $label;

    /** @ORM\Column(type="string") */
    protected $slug;

    /** @ORM\OneToMany(targetEntity="\App\Entity\Typed\Account", mappedBy="type")
     * @var Account
     */
    protected $accounts;

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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return Account
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * @param Account $accounts
     */
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;
    }


}