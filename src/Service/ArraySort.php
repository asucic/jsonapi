<?php declare(strict_types = 1);

namespace ASucic\JsonApi\Service;

class ArraySort
{
    public function sortIncluded(array $included): array
    {
        $sorted = [];
        foreach ($included as $item) {
            if (is_array($item)) {
                return $included;
            }

            if (strpos($item, '.') === false) {
                $sorted[$item] = [];

                continue;
            }

            [$parent, $child] = explode('.', $item, 2);
            $sorted[$parent] = $this->sortIncluded([$child]);
        }

        return $sorted;
    }
}