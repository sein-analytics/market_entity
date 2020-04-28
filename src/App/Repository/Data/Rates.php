<?php


namespace App\Repository\Data;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

abstract class Rates extends EntityRepository
{
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
        $sql = "SELECT name, value FROM $table";
        try {
            $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql);
        } catch (\Exception $e){
            return false;
        }
        return $stmt->fetchAll(Query::HYDRATE_ARRAY);
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
            if (array_key_exists(self::VALUE_KEY, $item))
                array_push($rates,
                    number_format(self::MULT * (float)$item[self::VALUE_KEY],
                        self::DEC_PLACES, '.', ','
                    )
                );
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