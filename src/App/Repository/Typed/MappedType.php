<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/6/17
 * Time: 2:02 PM
 */

namespace App\Repository\Typed;


use Doctrine\ORM\EntityRepository;

class MappedType extends EntityRepository
{
    protected $mappedRepos = [
        'armIndexType',  'purposeType', 'occupancyType', 'statusType', 'loanType', 'propertyType', 'documentationType'
    ];

    public function fetchAllMappedTypeData()
    {
        $result =[];
        foreach ($this->mappedRepos as $db){
            $name =ucfirst($db);
            $result[$db] = $this->getEntityManager()->getConnection()->fetchAll("SELECT * FROM $name");
        }
        return $result;
    }
}