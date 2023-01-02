<?php

namespace App\Entity;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="FileAccessCode")
 */
class FileAccessCode extends DomainObject
{
    const PUBLIC_ACC_LABEL = 'public';

    const AUTH_ACC_LABEL = 'authenticated';

    const PRIVATE_ACC_LABEL = 'private';

    const ACCESS_LABEL_TO_ID = [
        self::PUBLIC_ACC_LABEL => 1,
        self::AUTH_ACC_LABEL => 2,
        self::PRIVATE_ACC_LABEL => 3
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     **/
    protected int $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected string $label = '';

    /**
     * @return array
     */
    static public function getLabelToIdMapper ():array {
        return self::ACCESS_LABEL_TO_ID;
    }

    /**
     * @return int
     */
    public function getId(): int { return $this->id; }

    /**
     * @return string
     */
    public function getLabel(): string { return $this->label; }
}