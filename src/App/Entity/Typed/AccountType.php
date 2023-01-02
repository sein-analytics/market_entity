<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\Typed;

//use Doctrine\ORM\Mapping as ORM;
use App\Entity\AnnotationMappings;

/**
 * @author Samuel Belu-John
 *
 * \Doctrine\ORM\Mapping\Entity
 * \Doctrine\ORM\Mapping\Table(name="AccountType")
 */
class AccountType extends AnnotationMappings
{
    /**
     * \Doctrine\ORM\Mapping\Id
     * \Doctrine\ORM\Mapping\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     */
    protected int $id;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string")
     */
    protected string $label;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string")
     */
    protected string $slug;

    /**
     * \Doctrine\ORM\Mapping\OneToMany(targetEntity="\App\Entity\Typed\Account", mappedBy="type")
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