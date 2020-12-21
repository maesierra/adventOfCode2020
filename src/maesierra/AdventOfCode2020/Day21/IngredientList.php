<?php


namespace maesierra\AdventOfCode2020\Day21;


class IngredientList {

    private $ingredients = [];
    private $candidates = [];
    public $history = [];
    private $ingredient;
    private $allergen;
    private $len;
    /** @var Entry[] */
    public $entries = [];



    public function addIngredient(array $ingredients) {
        foreach ($ingredients as $ingredient) {
            if (!isset($this->ingredients[$ingredient])) {
                $this->ingredients[$ingredient] = null;
            }
        }
    }

    public function addAllergens(array $allergens) {
        foreach ($allergens as $allergen) {
            if (!isset($this->candidates[$allergen])) {
                $this->candidates[$allergen] = [];
                $this->len++;
            }
        }
    }

    public function withoutAllergens(): array {
        return array_keys(array_filter($this->ingredients, function ($i) {
            return is_null($i);
        }));
    }

    public function allMatched(): bool {
        return count($this->matched()) == $this->len;
    }

    public function isAllergenMatched($allergen): bool {
        return in_array($allergen, array_values($this->matched()));
    }
    public function isIngredientMatched($ingredient): bool {
        return isset($this->ingredients[$ingredient]);
    }

    public function use($allergen, $ingredient) {
        $this->ingredients[$ingredient] = $allergen;
        $pos = array_search($ingredient, $this->candidates[$allergen]);
        if ($pos !== false) {
            unset($this->candidates[$allergen][$pos]);
        }
        $this->ingredient = $ingredient;
        $this->allergen = $allergen;
        $this->history[] = $allergen;
    }

    public function next($allergen = null, $ingredient = null):array {
        if (!$ingredient || !$allergen) {
            if ($this->ingredient) {
                $this->ingredients[$this->ingredient] = null;
            }
            $this->ingredient = null;
            while (!$this->ingredient) {
                $this->allergen = array_pop($this->history);
                if (!$this->allergen) {
                    die("No history");
                }
                do {
                    $this->ingredient = array_shift($this->candidates[$this->allergen]);
                } while ($this->isIngredientMatched($this->ingredient));

            }
            $this->clearMatched();
        }
        //Clone entries
        $cloned = array_map(function($e) {
            return new Entry($e->ingredients, $e->allergens);
        }, $this->entries);
        foreach ($this->matched() as $i => $a) {
            foreach ($cloned as $entry) {
                $entry->remove($i, $a);
            }
        }
        return [$this->ingredient, $this->allergen, $cloned];
    }

    public function addOptions($allergen, array $ingredients) {
        foreach ($ingredients as $ingredient) {
            if (!in_array($ingredient, $this->candidates[$allergen])) {
                $this->candidates[$allergen][] = $ingredient;
            }
        }
        $this->candidates[$allergen] = array_unique($this->candidates[$allergen]);
    }

    public function clearMatched() {
        foreach ($this->ingredients as $ingredient => $a) {
            if ($a && !in_array($a, $this->history)) {
                $this->ingredients[$ingredient] = null;
            }
        }
    }

    public function __toString() {
        $matched = $this->matched();
        uasort($matched, function($a1, $a2) {
            return array_search($a1, $this->history) <=> array_search($a2, $this->history);
        });
        return implode(",", array_map(function($i, $a) {
            return "$a:$i";
        }, array_keys($matched), array_values($matched)));
    }

    /**
     * @return array
     */
    public function matched(): array
    {
        return array_filter($this->ingredients, function ($i) {
            return $i;
        });
    }

    public function addEntry(Entry $entry) {
        $this->entries[] = $entry;
    }

    public function getFirstEntry():Entry {
        $entries = $this->entries;
        usort($entries, function($e1, $e2) {
            /** @var Entry $e1 */
            /** @var Entry $e2 */
            $cmp = count($e2->allergens) - count($e1->allergens);
            if ($cmp == 0) {
                return $cmp = count($e1->ingredients) - count($e2->ingredients);
            }
            return $cmp * -1;
        });
        return reset($entries);
    }

    /**
     * @param $allergen
     * @param $ingredient
     * @return bool
     */
    public function isValid($allergen, $ingredient): bool {
        foreach ($this->entries as $entry) {
            if ($entry->containsAllergen($allergen) && !$entry->containsIngredient($ingredient)) {
                return false;
            }
        }
        return true;
    }



}