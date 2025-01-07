<?php


namespace App\Repository\Data;

use App\Repository\DbalStatementInterface;
use Doctrine\ORM\EntityRepository;
use App\Service\FetchingTrait;

abstract class Rates extends EntityRepository implements DbalStatementInterface
{

    use FetchingTrait;

    const LABELS_KEY = 'labels';

    const RATES_KEY = 'rates';

    const NAME_KEY = 'name';

    const VALUE_KEY = 'value';

    const MULT = 100;

    const DEC_PLACES = 3;

    const SWAPS_KEY = 'Swaps';

    const YIELDS_KEY = 'Treasuries';

    public function fetchRates(string $table)
    {
        try {
            $results = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                "SELECT name, value FROM $table",
                self::FETCH_ALL_ASSO_MTHD
            );
        } catch (\Exception $e){
            return false;
        }
        return $results;
    }

    /**
     * @param array $dbData
     * @param string $name
     * @return \array[][]
     */
    public function rawDataToLabelsRates(array $dbData, string $name)
    {
        $labels = []; $rates = [];
        array_walk($dbData, function ($item, $key) use(&$labels, &$rates) {
            if (array_key_exists(self::NAME_KEY, $item))
                array_push($labels, $item[self::NAME_KEY]);
            if (array_key_exists(self::VALUE_KEY, $item)){
                $float = (float)$item[self::VALUE_KEY];
                array_push($rates,
                    number_format(self::MULT * $float,
                        self::DEC_PLACES, '.', ','
                    )
                );
            }
        });
        return [
            $name => [
                self::LABELS_KEY => $labels,
                self::RATES_KEY => $rates
            ]
        ];
    }

    /**
     * @param array $swaps
     * @param array $yields
     * @return array|bool
     */
    public function combineCurves(array $swaps, array $yields)
    {
        if (!array_key_exists(strtolower(self::SWAPS_KEY), $swaps)
            && !array_key_exists(strtolower(self::YIELDS_KEY), $yields))
            return false;
        if (!array_key_exists(self::LABELS_KEY, $swaps[strtolower(self::SWAPS_KEY)])
            && !array_key_exists(self::LABELS_KEY, $swaps[strtolower(self::YIELDS_KEY)]))
            return false;
        if (!array_key_exists(self::RATES_KEY, $swaps[strtolower(self::SWAPS_KEY)])
            && !array_key_exists(self::RATES_KEY, $swaps[strtolower(self::YIELDS_KEY)]))
            return false;
        return [
            self::LABELS_KEY => $swaps[strtolower(self::SWAPS_KEY)][self::LABELS_KEY],
            self::RATES_KEY => [
                strtolower(self::YIELDS_KEY) => $yields[strtolower(self::YIELDS_KEY)][self::RATES_KEY],
                strtolower(self::SWAPS_KEY) => $swaps[strtolower(self::SWAPS_KEY)][self::RATES_KEY]
            ]
        ];
    }
}