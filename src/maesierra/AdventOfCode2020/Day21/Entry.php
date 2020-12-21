<?php


namespace maesierra\AdventOfCode2020\Day21;


class Entry {

    public $ingredients = [];
    public $allergens = [];

    /**
     * Entry constructor.
     * @param array $ingredients
     * @param array $allergens
     */
    public function __construct(array $ingredients, array $allergens)
    {
        $this->ingredients = $ingredients;
        $this->allergens = $allergens;
    }

    public function containsAllergen($allergen): bool {
        return in_array($allergen, $this->allergens);
    }

    public function containsIngredient($ingredient): bool {
        return in_array($ingredient, $this->ingredients);
    }

    public function remove($ingredient, $allergen) {
        $pos = array_search($ingredient, $this->ingredients);
        if ($pos !== false) {
            unset($this->ingredients[$pos]);
        }
        $pos = array_search($allergen, $this->allergens);
        if ($pos !== false) {
            unset($this->allergens[$pos]);
        }
    }

    public function countIngredients(): int {
        return count($this->ingredients);
    }

    public function countAllergens(): int {
        return count($this->allergens);
    }


}