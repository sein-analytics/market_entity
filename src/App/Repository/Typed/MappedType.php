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
        'armIndexType' => 'rateIndex',
        'purposeType' => 'purpose',
        'occupancyType' => 'occupancy',
        'statusType' => 'loanStatus',
        'loanType' => 'loanType',
        'propertyType' => 'dwelling',
        'documentationType' => 'documentation',
        'state' => 'state'
    ];

    /**
     * @return array
     */
    public function fetchAllMappedTypeData()
    {
        $result =[];
        foreach ($this->mappedRepos as $db => $propName){
            $name =ucfirst($db);
            $result[$propName] = $this->getEntityManager()->getConnection()->fetchAll("SELECT * FROM $name");
        }
        return $result;
    }

    /**
     * @param array $states
     * @param string $stateText
     * @return int|bool
     */
    public function stateIdFromStatesArray(array $states, string $stateText){
        foreach ($states as $stateProps){
            if($stateText == $stateProps['abbreviation']
                || $stateText == $stateProps['name']){
                return $stateProps['id'];
            }
        }
        return false;
    }
}