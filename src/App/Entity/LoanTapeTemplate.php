<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/17/17
 * Time: 9:52 AM
 */

namespace App\Entity;

use App\Entity\MarketUser;
use App\Service\CreatePropertiesArrayTrait;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Repository\LoanTapeTemplate")
 * @ORM\Table(name="LoanTapeTemplate")
 */
class LoanTapeTemplate 
{
    use CreatePropertiesArrayTrait, FetchingTrait, FetchMapperTrait;

    /**
     * @ORM\Id 
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     **/
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MarketUser", inversedBy="templates")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DealAsset", inversedBy="templates")
     * @ORM\JoinColumn(name="asset_id", referencedColumnName="id", nullable=true)
     * @var DealAsset
     */
    protected $type;

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
     * @return int
     */
    public function getId():int { return $this->id; }

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
            $templateArray = json_decode($this->template, true);
            return $templateArray;
        }
        return $this->template;
    }

    /**
     * @param array $template
     */
    public function setTemplate(array $template)
    {
        $template_st = json_encode($template, JSON_UNESCAPED_SLASHES);
        $this->template = $template_st;
    }

    /**
     * @return DealAsset
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $templateName
     */
    public function setTemplateName(string $templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * @param DealAsset $type
     */
    public function setType(DealAsset $type)
    {
        $this->type = $type;
    }



}