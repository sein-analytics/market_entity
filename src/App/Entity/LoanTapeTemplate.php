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

/**
 * \Doctrine\ORM\Mapping\Entity(repositoryClass="\App\Repository\LoanTapeTemplate")
 * \Doctrine\ORM\Mapping\Table(name="LoanTapeTemplate")
 */
class LoanTapeTemplate extends AnnotationMappings
{
    use CreatePropertiesArrayTrait, FetchingTrait, FetchMapperTrait;

    /**
     * \Doctrine\ORM\Mapping\Id @ORM\Column(type="integer")
     * \Doctrine\ORM\Mapping\GeneratedValue
     **/
    protected $id;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="App\Entity\MarketUser", inversedBy="templates")
     * \Doctrine\ORM\Mapping\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var MarketUser
     **/
    protected $user;

    /**
     * \Doctrine\ORM\Mapping\ManyToOne(targetEntity="App\Entity\DealAsset", inversedBy="templates")
     * \Doctrine\ORM\Mapping\JoinColumn(name="asset_id", referencedColumnName="id", nullable=true)
     * @var DealAsset
     */
    protected $type;

    /**
     * \Doctrine\ORM\Mapping\Column(type="json", nullable=false)
     * @var array | null
     *
     **/
    protected $template;

    /**
     * \Doctrine\ORM\Mapping\Column(type="string", nullable=false)
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