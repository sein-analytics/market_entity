<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/17/17
 * Time: 9:52 AM
 */

namespace App\Entity;

use App\Entity\MarketUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\LoanTapeTemplate")
 * @ORM\Table(name="LoanTapeTemplate")
 */
class LoanTapeTemplate
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MarketUser", inversedBy="templates")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * @ORM\Column(type="json", nullable=false)
     * @var array | null
     *
     **/
    protected $template;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     *
     **/
    protected $templateName;

    /**
     * @return mixed
     */
    public function getId() { return $this->id; }

    /**
     * @return \App\Entity\MarketUser
     */
    public function getUser() { return $this->user; }

    /**
     * @return string
     */
    public function getTemplateName() { return $this->templateName; }

    /**
     * @param \App\Entity\MarketUser $user
     */
    public function setUsers(\App\Entity\MarketUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getTemplate()
    {
        if(is_string($this->template)){
            $templateArray = json_decode($this->template);
            return $templateArray;
        }
        return $this->template;
    }

    /**
     * @param array $template
     */
    public function setTemplate(array $template)
    {
        $template_st = json_encode($template);
        $this->template = $template_st;
    }


}