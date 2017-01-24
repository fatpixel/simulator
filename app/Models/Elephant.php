<?php
namespace SimpleZoo\Models;

/**
 * Class Elephant
 * @package SimpleZoo\Models
 */
class Elephant extends Animal
{
    /**
     *
     */
    const GENOTYPE = 'Elephant';
    /**
     *
     */
    const MINIMUM_HEALTH = 70.0;

    /**
     * @var bool
     */
    public $walking;

    /**
     * Elephant constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->walking = true;
    }

    /**
     * @inheritdoc
     */
    protected function checkMortality()
    {
        if ($this->health <= static::MINIMUM_HEALTH) {

            if ($this->walking) {
                $this->walking = false;
            } else {
                $this->alive = false;
                $this->health = 0.0;
            }

        } else {

            if ($this->alive && !$this->walking) {
                $this->walking = true;
            }

        }

        return $this->alive;
    }
}
