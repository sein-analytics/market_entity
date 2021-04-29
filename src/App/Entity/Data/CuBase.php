<?php


namespace App\Entity\Data;

use App\Entity\Data\State;
use App\Entity\Data\CunaType;
use App\Entity\Data\CunaRegion;

/**
 * @ORM\Entity()
 * @ORM\Table(name="CuBase")
 */
class CuBase
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     **/
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $address;

    /**
     * @ORM\Column(type="string")
     * @var string
     **/
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\State")
     * @JoinColumn(name="state_id", referencedColumnName="id")
     * @var State
     **/
    protected $state;

    /** @ORM\Column(type="string", nullable=false) */
    protected $zip;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\CunaType")
     * @JoinColumn(name="type_id", referencedColumnName="id")
     * @var CunaType
     **/
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Data\CunaRegion")
     * @JoinColumn(name="type_id", referencedColumnName="id")
     * @var CunaRegion
     **/
    protected $region;

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getName(): string { return $this->name; }

    /**
     * @return string
     */
    public function getAddress(): string { return $this->address; }

    /**
     * @return string
     */
    public function getCity(): string { return $this->city; }

    /**
     * @return State
     */
    public function getState(): State { return $this->state; }

    /**
     * @return mixed
     */
    public function getZip() { return $this->zip; }

    /**
     * @return CunaType
     */
    public function getType(): CunaType { return $this->type; }

    /**
     * @return CunaRegion
     */
    public function getRegion(): CunaRegion { return $this->region; }
    


}