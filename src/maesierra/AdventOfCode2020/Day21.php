<?php


namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day21\Entry;
use maesierra\AdventOfCode2020\Day21\IngredientList;

class Day21 {


    public function question1(string $inputFile):int {
        $ingredients = $this->createIngredients($inputFile);
        $withoutAllergens = $ingredients->withoutAllergens();
        return array_reduce($ingredients->entries, function($sum, $entry) use($withoutAllergens) {
            /** @var Entry $entry */
                return array_reduce($withoutAllergens, function($s, $i) use($entry) {
                if ($entry->containsIngredient($i)) {
                    $s++;
                }
                return $s;
            }, $sum);
        }, 0);
    }

    public function question2(string $inputFile):string {
        $ingredients = $this->createIngredients($inputFile);
        $matched = $ingredients->matched();
        asort($matched);
        return implode(",", array_keys($matched));
    }

    /**
     * @param string $inputFile
     * @return IngredientList
     */
    private function createIngredients(string $inputFile): IngredientList {
        $ingredients = new IngredientList();
        foreach (explode("\n", file_get_contents($inputFile)) as $line) {
            if (!$line) {
                continue;
            }
            preg_match('/(.*) \(contains (.*)\)/', $line, $matches);
            $ingredientsList = explode(' ', $matches[1]);
            $allergens = preg_split('/, /', $matches[2], -1, PREG_SPLIT_NO_EMPTY);
            $ingredients->addEntry(new Entry($ingredientsList, $allergens));
            $ingredients->addIngredient($ingredientsList);
            $ingredients->addAllergens($allergens);
        }

        $entry = $ingredients->getFirstEntry();
        foreach ($entry->allergens as $allergen) {
            $ingredients->addOptions($allergen, $entry->ingredients);
        }
        list($ingredient, $allergen, $currentEntries) = $ingredients->next(
            reset($entry->allergens),
            reset($entry->ingredients)
        );
        while (!$ingredients->allMatched()) {
            $ingredients->use($allergen, $ingredient);
            echo "Attempt {$ingredients}\n";
            if (!$ingredients->isValid($allergen, $ingredient)) {
                list($ingredient, $allergen, $currentEntries) = $ingredients->next();
            } else {
                /** @var Entry[][] $oneAllergenEntries */
                $oneAllergenEntries = [];
                foreach ($currentEntries as $entry) {
                    $entry->remove($ingredient, $allergen);
                    if ($entry->countAllergens() == 1) {
                        $a = reset($entry->allergens);
                        if (!$ingredients->isAllergenMatched($a)) {
                            $list = $oneAllergenEntries[$a] ?? [];
                            $list[] = $entry;
                            $oneAllergenEntries[$a] = $list;
                        }
                    }
                }
                if ($oneAllergenEntries) {
                    $valid = true;
                    foreach ($oneAllergenEntries as $a => $list) {
                        if (count($list) == 1) {
                            continue;
                        }
                        $intersect = array_reduce($list, function ($intersects, $e) {
                            /** @var $e Entry */
                            return array_intersect($intersects, $e->ingredients);
                        }, $list[0]->ingredients);
                        if (!$intersect) {
                            $valid = false;
                            break;
                        }
                    }
                } else {
                    $valid = $ingredients->allMatched();
                }
                if ($valid) {
                    if (!$ingredients->allMatched()) {
                        /** @var Entry $entry */
                        $allergen = array_keys($oneAllergenEntries)[0];
                        foreach ($oneAllergenEntries[$allergen] as $entry) {
                            $ingredients->addOptions($allergen, $entry->ingredients);
                        }
                        $entry = $oneAllergenEntries[$allergen][0];
                        $ingredient = reset($entry->ingredients);
                    }

                } else {
                    list($ingredient, $allergen, $currentEntries) = $ingredients->next();
                }
            }

        }
        return $ingredients;
    }


}