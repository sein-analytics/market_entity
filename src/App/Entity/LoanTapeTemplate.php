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

#[ORM\Table(name: 'LoanTapeTemplate')]
#[ORM\Entity(repositoryClass: \App\Repository\LoanTapeTemplate::class)]
class LoanTapeTemplate 
{
    use CreatePropertiesArrayTrait, FetchingTrait, FetchMapperTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var MarketUser
     **/
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: MarketUser::class, inversedBy: 'templates')]
    protected $user;

    /**
     * @var DealAsset
     */
    #[ORM\JoinColumn(name: 'asset_id', referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity: DealAsset::class, inversedBy: 'templates')]
    protected $type;

    /**
     * @var array | null
     *
     **/
    #[ORM\Column(type: 'json', nullable: false)]
    protected $template;

    /**
     * @var string
     *
     **/
    #[ORM\Column(type: 'string', nullable: false)]
    protected $templateName;

    /**
     * @return int
     */
    public function getId():int { return $this->id; }

    /**
     * @return MarketUser
     */
    public function getUser() { return $this->user; }

    /**
     * @return string
     */
    public function getTemplateName() { return $this->templateName; }

    /**
     * @param MarketUser $user
     */
    public function setUsers(MarketUser $user)
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