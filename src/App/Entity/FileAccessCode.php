<?php

namespace App\Entity;
use Doctrine\ORM\Mapping\ChangeTrackingPolicy;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'FileAccessCode')]
#[ORM\Entity]
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
     * @var int
     **/
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    protected int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
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