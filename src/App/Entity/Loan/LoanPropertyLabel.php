<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/25/17
 * Time: 9:44 AM
 */

namespace App\Entity\Loan;


use App\Repository\Loan\LoanInterface;
use App\Service\CreatePropertiesArrayTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Mapping as ORM;
use const Lambdish\Phunctional\each;

class LoanPropertyLabel extends EntityRepository
implements LoanInterface
{
    use CreatePropertiesArrayTrait;

    const XL_FORMAT_SUBTRAHEND = 25569;

    const XL_FORMAT_MULTIPLIER = 86400;

    private array $propertyLabels = [
        "id" => null,
        "pool_id" => null,
        "zero_balance_date" => 'zero_balance_date',
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
                return $this->decimalAndFloats($value);
            },
            "float" => function($value){
                return $this->decimalAndFloats($value);
            },
            "datetime" => function($value){
                $val = preg_replace('/[^0-9-\/]/', '', $value);
                try{
                    $date = new \DateTime($val);
                } catch (\Exception $e){
                    if (!($date = $this->excelDateConversion($value, $val)) instanceof \DateTime)
                        return "1970-10-10";
                }
                return $date->format("Y-m-d");
            },
            "string" => function($value){
                return $this->removeStringSpecialCharacters($value);
            }
        ];
        parent::__construct($em, $class);
    }

    protected function decimalAndFloats(mixed $value): float
    {
        //$val = preg_replace("/[^0-9.]/", "", $value);
        return round((float)preg_replace("/[^0-9.]/", "", $value), 2);
    }

    protected function removeStringSpecialCharacters(string $stringValue):string
    {
        $allowedSymbols = "-_.,\/";
        $pattern = '/[^a-zA-Z0-9\x20' . preg_quote($allowedSymbols, '/') . ']/u';
        return preg_replace($pattern, '', $stringValue);
    }

    /**
     * @param string $xlDate
     * @param string $cleanDate
     * @return string|\DateTime
     */
    protected function excelDateConversion(string $xlDate, string $cleanDate):string|\DateTime
    {
        if ($xlDate !== $cleanDate)
            return "Not XL format";
        try {
            return new \DateTime("@" . ($cleanDate - self::XL_FORMAT_SUBTRAHEND)*self::XL_FORMAT_MULTIPLIER);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
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
            $row = $this->assignRowLabel($row, $properties);
            $row = $this->assignFieldMappingsToRow($row, $properties);
            $row = $this->assignSignificance($properties, $row);
            $row = $this->assignCategory($row);
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
                if(strlen($search[self::SEARCH_KEY]) === 0){
                    continue;
                }
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

    public function assignRowLabel(array $row, array $properties):array
    {
        if (array_key_exists($properties[self::ENTITY_COLUMN], $this->propertyLabels)
            && !is_null($this->propertyLabels[$properties[self::ENTITY_COLUMN]])){
            $label = $this->propertyLabels[$properties[self::ENTITY_COLUMN]];
            $row[self::LABEL] = ucwords(str_replace('_',' ', $label));
        } else {
            $row[self::LABEL] = ucwords(str_replace('_',' ', $properties[self::ENTITY_COLUMN]));
        }
        return $row;
    }

    /**
     * @param array $fieldMapping
     * @param $row
     * @return array
     */
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
     * @param array $row
     * @return array
     */
    public function assignCategory(array $row):array
    {
        if (array_key_exists($this->getClassMetadata()->getName(), self::LOAN_CATEGORY_MAPPER)){
            $row[self::CATEGORY] = self::LOAN_CATEGORY_MAPPER[$this->getClassMetadata()->getName()];
        } else {
            $row[self::CATEGORY] = self::LOANS_TABLE_CATEGORY;
        }
        return $row;
    }

    /**
     * @param array $row
     * @param array $properties
     * @return array
     */
    public function assignFieldMappingsToRow(array $row, array $properties):array
    {
        foreach (self::FIELD_MAPPINGS_TO_ROW as $key => $rowProp){
            $row[$rowProp] = $properties[$key];
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