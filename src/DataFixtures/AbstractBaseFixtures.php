<?php
/*
 * This file is part of the Terminarz application.
 *
 * (c) Radek Łada <radlad98@gmail.com>
 *
 * For the full copyright and license information, please contact the author.
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class AbstractBaseFixtures.
 */
abstract class AbstractBaseFixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Persistence object manager.
     *
     * @var \Doctrine\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Load.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);
    }

    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    abstract protected function loadData(ObjectManager $manager): void;
}
