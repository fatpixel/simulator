<?php
namespace SimpleZoo\Models;

/**
 * Class Animal
 * @package SimpleZoo\Models
 */
abstract class Animal
{

    /**
     * The "type" of animal.
     */
    const GENOTYPE = 'Animal';
    /**
     * The animal's minimum health
     */
    const MINIMUM_HEALTH = 0.0;

    /**
     * @var float
     */
    protected $health;
    /**
     * @var bool
     */
    protected $alive;

    /**
     * Animal constructor.
     */
    public function __construct()
    {
        $this->health = 100.0;
        $this->alive = true;
    }

    /**
     * Calculates a percentage of this animal's current health.
     *
     * @param $percentage
     * @return float
     */
    private function getPercentageOfHealth($percentage)
    {
        return (float) abs($this->health * $percentage);
    }

    /**
     * Check if this animal's "time is up".
     * @return bool
     */
    protected function checkMortality()
    {
        if ($this->health <= static::MINIMUM_HEALTH) {
            $this->alive = false;
            $this->health = 0.0;
        }

        return $this->alive;
    }

    /**
     * @return string
     */
    public function getGenotype()
    {
        return static::GENOTYPE;
    }

    /**
     * Increases the health of the animal by a specified percentage of their current health.
     *
     * @param $percentageOfCurrentHealth
     * @return $this
     */
    public function increaseHealth($percentageOfCurrentHealth)
    {
        $amount = $this->getPercentageOfHealth($percentageOfCurrentHealth);

        $this->health = min($this->health + $amount, 100.0);

        return $this;
    }

    /**
     * Decreases the health of the animal by a specified percentage of their current health.
     *
     * @param $percentageOfCurrentHealth
     * @return $this
     */
    public function decreaseHealth($percentageOfCurrentHealth)
    {
        $amount = $this->getPercentageOfHealth($percentageOfCurrentHealth);

        $this->health = max($this->health - $amount, 0.0);

        $this->checkMortality();

        return $this;
    }

    /**
     * @return float
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @return bool
     */
    public function isAlive()
    {
        return $this->checkMortality();
    }

}