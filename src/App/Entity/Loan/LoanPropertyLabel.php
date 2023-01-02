<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/25/17
 * Time: 9:44 AM
 */

namespace App\Entity\Loan;


use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use JetBrains\PhpStorm\ArrayShape;
use Doctrine\ORM\Mapping as ORM;
class LoanPropertyLabel extends EntityRepository
{
    use CreatePropertiesArrayTrait;

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

    const DB_DATA = 'dbData';

    const LABEL = 'label';

    const ENTITY_TYPE = 'type';

    const ENTITY_FIELD = 'fieldName';

    const ENTITY_NULL = 'nullable';

    const ENTITY_COLUMN = 'columnName';

    const STATE_AB_KEY = 'abbreviation';

    const STATE_NAME_KEY = 'name';

    const SLUG_KEY = 'slug';

    const MAPPED_ID_KEY = 'mapped-id';

    const HAY_KEY = 'haystack';

    const SEARCH_KEY = 'search';

    const BASE_STATE_ID = 51;



    private array $propertyLabels = [
        "id" => null,
        "pool_id" => null,
        "zero_balance_date" => 'zero_balance_date',//
        "current_duefor_date" => "paid-through_date",
        "final_duefor_date" => "stated_maturity_date",
        "dwelling" => 'property_type',
        "state_id" => "state"
    ];

    private array $metaDataKeys = ['type', 'nullable', 'columnName'];

    private array $mortgageData = ['documentation', 'purpose','occupancy', 'dwelling', 'loan_type', 'address', 'state_id', 'city', 'zip', 'msa_code_id'];

    private array $creditData = ['credit_score', 'front_dti', 'back_dti', 'number_of_borrowers', 'first_time_buyer', 'status', 'payment_string', 'lien_position'];

    private array $idProp = [
        "category"  => "dbData",
        "dbName"    => "id",
        "significance" => self::DB_DATA,
        "label"     => "id",
        'type'  => 'integer',
        'id'  => 0
    ];

    private array $poolProp = [
        "category"  => "dbData",
        "dbName"    => "pool_id",
        "significance" => self::DB_DATA,
        "label"     => "pool_id",
        'type'  => 'integer',
        'id'  => 1
    ];

    private array $stateProp = [
        "category"  => "loanData",
        "dbName"    => "state_id",
        "significance" => "required",
        "label"     => "State",
        'type'  => 'integer',
        'id'  => 2
    ];

    private array $msaProp = [
        "category"  => "loanData",
        "dbName"    => "msa_code_id",
        "significance" => "optional",
        "label"     => "MSA CODE",
        'type'  => 'integer',
        'id'  => 3
    ];

    private array $amortizationProp = [
        "category"  => "dbData",
        "dbName"    => "amortization_id",
        "significance" => self::DB_DATA,
        "label"     => "amortization_id",
        'type'  => 'integer',
        'id'  => 4
    ];

    private array $descriptionProp = [
        "category"  => "dbData",
        "dbName"    => "description_id",
        "significance" => self::DB_DATA,
        'type'  => 'integer',
        "label"     => "description_id",
        'id'  => 5
    ];

    protected array $dbTypeSanitizer = [];

    public function __construct(EntityManager $em, Mapping\ClassMetadata $class)
    {
        $this->dbTypeSanitizer = [
            "integer" => function($value){
                $val = preg_replace("/[^0-9.]/", "", $value);
                return (int)$val;
            },
            "decimal" => function($value){
                $val = preg_replace("/[^0-9.]/", "", $value);
                return round((float)$val, 2);
            },
            "datetime" => function($value){
                $val = preg_replace('/[^0-9-\/]/', '', $value);
                try{
                    $date = new \DateTime($val);
                } catch (\Exception $e){
                    //return $e->getMessage();
                    return "1970-10-10";
                }
                return $date->format("Y-m-d");
            },
            "string" => function($value){
                return $value;
            }
        ];
        parent::__construct($em, $class);
    }

    /**
     * @param array $data
     * @param int $count
     * @param bool $addState
     * @return array
     */
    public function buildTapeUploadArray(array $data = array(), int $count = 0, bool $addState=true):array
    {
        $data = $this->addStateProp($data, $addState);
        foreach ($this->getClassMetadata()->fieldMappings as $propName => $properties){
            if(array_key_exists($properties[self::ENTITY_COLUMN], $this->propertyLabels)
                && is_null($this->propertyLabels[$properties[self::ENTITY_COLUMN]])){
                continue;
            }
            $row['id'] = $count;
            $row = $this->assignDataType($properties, $row);
            if (array_key_exists($properties[self::ENTITY_COLUMN], $this->propertyLabels)
                && !is_null($this->propertyLabels[$properties[self::ENTITY_COLUMN]])){
                $label = $this->propertyLabels[$properties[self::ENTITY_COLUMN]];
                $row[self::LABEL] = ucwords(str_replace('_',' ', $label));
            } else {
                $row[self::LABEL] = ucwords(str_replace('_',' ', $properties[self::ENTITY_COLUMN]));
            }
            $row[self::DB_NAME] = $properties[self::ENTITY_COLUMN];
            $row[self::ENTITY_TYPE] = $properties[self::ENTITY_TYPE];
            $row = $this->assignSignificance($properties, $row);
            array_push($data, $row);
            $count++;
        }
        return $data;
    }

    /**
     * @param mixed $userValue
     * @param array $searchArray
     * @param array $dbProperties
     * @return array
     */
    public function searchForUserStateValue(mixed $userValue, array $searchArray, array $dbProperties):array
    {
        $userValue = $this->mappedTypeSanitizer($userValue);
        foreach ($searchArray as $dbData){
            if(!array_key_exists(self::STATE_AB_KEY, $dbData)
                || !array_key_exists(self::STATE_NAME_KEY, $dbData))
            { continue; }
            if(strtoupper($userValue) === strtoupper($dbData[self::STATE_AB_KEY]))
            {
                $dbProperties[self::MAPPED_ID_KEY] = (int)$dbData['id'];
                $dbProperties[self::LABEL] = $dbData[self::STATE_AB_KEY];
                return $dbProperties;
            }
        }
        $dbProperties[self::MAPPED_ID_KEY] = self::BASE_STATE_ID;
        $dbProperties[self::LABEL] = 'NA';
        return $dbProperties;
    }

    /**
     * @param mixed $userValue
     * @param array $searchArray
     * @param array $dbProperties
     * @return array
     */
    public function searchForMappedTypeValue(mixed $userValue, array $searchArray, array $dbProperties):array
    {
        $userValue = $this->mappedTypeSanitizer($userValue);
        foreach ($searchArray as $dbData){
            if(!array_key_exists(self::SLUG_KEY, $dbData))
            { continue; }
            $searches = preg_split('/\s+/', $dbData[self::SLUG_KEY]);
            foreach ($searches as $slug){
                $search = $this->searchVsHaystack($userValue, $slug);
                $pos = strrpos($search[self::HAY_KEY], $search[self::SEARCH_KEY]);
                if($pos !== FALSE){
                    $dbProperties[self::MAPPED_ID_KEY] =(int) $dbData['id'];
                    $dbProperties[self::LABEL] = $dbData[self::LABEL];
                    return $dbProperties;
                }
            }
        }
        $dbProperties[self::MAPPED_ID_KEY] = 1;
        $dbProperties[self::LABEL] = 'Other';
        return $dbProperties;
    }

    /**
     * @param string $string
     * @return string|array|null
     */
    public function mappedTypeSanitizer(string $string): string|array|null
    {
        $string = preg_replace('/[^a-zA-Z0-9-_.\/]/', '', $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;

    }

    /**
     * @param array $fieldMapping
     * @param array $row
     * @return array
     */
    public function assignDataType(array $fieldMapping, array $row):array
    {
        if(in_array($fieldMapping[self::ENTITY_COLUMN], $this->creditData)){
            $row[self::CATEGORY] = self::CREDIT_DATA ;
        } elseif (in_array($fieldMapping[self::ENTITY_COLUMN], $this->mortgageData)){
            $row[self::CATEGORY] = self::MTGE_DATA;
        } elseif ($this->getClassMetadata()->getName() == 'App\Entity\Loan\ArmAttribute'){
            $row[self::CATEGORY] = self::ARM_DATA;
        } else {
            $row[self::CATEGORY] = self::LOAN_DATA;
        }
        return $row;
    }

    public function assignSignificance(array $fieldMapping, $row):array {
        if($this->getClassMetadata()->getName() == 'App\Entity\Loan\ArmAttribute'){
            $row[self::SIGNIFICANCE] = self::CONDITIONAL;
        }elseif ($fieldMapping[self::ENTITY_NULL]){
            $row[self::SIGNIFICANCE] = self::OPTIONAL;
        }else{
            $row[self::SIGNIFICANCE] = self::REQUIRED;
        }
        return $row;
    }

    /**
     * @param array $data
     * @param bool $addProps
     * @return array
     */
    private function addStateProp(array $data, bool $addProps=false):array {
        if($addProps){
            $data[] = $this->idProp;
            $data[] = $this->poolProp;
            $data[] = $this->stateProp;
            $data[] = $this->msaProp;
            $data[] = $this->amortizationProp;
            $data[] = $this->descriptionProp;
        }
        return $data;
    }

    /**
     * @param string $search1
     * @param string $search2
     * @return array
     */
    #[ArrayShape([self::HAY_KEY => "string", self::SEARCH_KEY => "string"])]
    public function searchVsHaystack(string $search1, string $search2):array
    {
        if(strlen($search1) >= strlen($search2)){
            return [
                self::HAY_KEY => $search1,
                self::SEARCH_KEY => $search2
            ];
        }else {
            return [
                self::HAY_KEY => $search2,
                self::SEARCH_KEY => $search1
            ];
        }
    }

    public function getPropertyLabels():array { return $this->propertyLabels; }

    public function getDbTypeSanitizer():array { return $this->dbTypeSanitizer; }
}