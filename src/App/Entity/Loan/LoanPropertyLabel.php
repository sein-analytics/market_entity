<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/25/17
 * Time: 9:44 AM
 */

namespace App\Entity\Loan;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

class LoanPropertyLabel extends EntityRepository
{
    const LOAN_DATA = 'loanData';

    const CREDIT_DATA = 'creditData';

    const MTGE_DATA = 'mortgageData';

    const ARM_DATA = 'armData';

    const FEES_DATA = 'feesData';

    const CATEGORY = 'category';

    const SIGNIFICANCE = 'significance';

    const DB_NAME = 'dbName';

    const REQUIRED = 'required';

    const OPTIONAL = 'optional';

    const CONDITIONAL = 'conditional';

    const LABEL = 'label';

    const ENTITY_TYPE = 'type';

    const ENTITY_FIELD = 'fieldName';

    const ENTITY_NULL = 'nullable';

    const ENTITY_COLUMN = 'columnName';

    private $propertyLabels = [
        "id" => null,
        "pool_id" => null,
        "zero_balance_date" => null,
        "current_duefor_date" => "paid-through_date",
        "final_duefor_date" => "stated_maturity_date",
        "dwelling" => 'property_type',
        "state_id" => "state"
    ];

    private $metaDataKeys = ['type', 'nullable', 'columnName'];

    private $mortgageData = ['documentation', 'purpose','occupancy', 'dwelling', 'loan_type', 'address', 'state_id', 'city', 'zip', 'msa_code_id'];

    private $creditData = ['credit_score', 'front_dti', 'back_dti', 'number_of_borrowers', 'first_time_buyer', 'status', 'payment_string', 'lien_position'];

    public function __construct(EntityManager $em, Mapping\ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

    /**
     * @param array $data
     * @param int $count
     * @return array
     */
    public function buildTapeUploadArray($data = array(), $count = 0)
    {
        foreach ($this->getClassMetadata()->fieldMappings as $propName => $properties){
            if(in_array($properties[self::ENTITY_COLUMN], $this->propertyLabels)
                && $this->propertyLabels[$properties[self::ENTITY_COLUMN]] == null){
                continue;
            }
            $row['id'] = $count++;
            $row = $this->assignDataType($properties, $row);
            if (in_array($properties[self::ENTITY_COLUMN], $this->propertyLabels)
                && !is_null($this->propertyLabels[$properties[self::ENTITY_COLUMN]])){
                $properties[self::ENTITY_COLUMN] = $this->propertyLabels[$properties[self::ENTITY_COLUMN]];
            }
            $row[self::DB_NAME] = $properties[self::ENTITY_COLUMN];
            $row[self::LABEL] = ucwords(str_replace('_',' ', $properties[self::ENTITY_COLUMN]));
            $row = $this->assignSignificance($properties, $row);
            array_push($data, $row);
        }
        return $data;
    }

    /**
     * @param array $fieldMapping
     * @param array $row
     * @return array
     */
    public function assignDataType(array $fieldMapping, array $row)
    {
        if(in_array($fieldMapping[self::ENTITY_COLUMN], $this->creditData)){
            $row[self::CATEGORY] = self::CREDIT_DATA ;
        } elseif (in_array($fieldMapping[self::ENTITY_COLUMN], $this->mortgageData)){
            $row[self::CATEGORY] = self::MTGE_DATA;
        } elseif ($this->getClassMetadata()->getName() == '\App\Entity\Loan\ArmAttribute'){
            $row[self::CATEGORY] = self::ARM_DATA;
        } else {
            $row[self::CATEGORY] = self::LOAN_DATA;
        }
        return $row;
    }

    public function assignSignificance(array $fieldMapping, $row){
        if($this->getClassMetadata()->getName() == '\App\Entity\Loan\ArmAttribute'){
            $row[self::SIGNIFICANCE] = self::CONDITIONAL;
        }elseif ($fieldMapping[self::ENTITY_NULL]){
            $row[self::SIGNIFICANCE] = self::OPTIONAL;
        }else{
            $row[self::SIGNIFICANCE] = self::REQUIRED;
        }
        return $row;
    }

    public function getPropertyLabels()
    {
        return $this->propertyLabels;
    }
}