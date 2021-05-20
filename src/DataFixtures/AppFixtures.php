<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categoryNamesToAdd = [
            'studia',
            'praca',
            'wolne',
        ];
        $category = [];
        for ($i = 0; $i < count($categoryNamesToAdd); ++$i) {
            $category[$i] = new Category();
            $category[$i]->setName($categoryNamesToAdd[$i]);
            $manager->persist($category[$i]);
        }

        $manager->flush();

        $faker = Factory::create();
        for ($i = 0; $i < 30; ++$i) {
            $event = new Event();
            $sentence = $faker->sentence;
            $event->setTitle(explode(' ', $sentence)[0]);
            $event->setDescription($faker->sentence);
            $event->setStartTime($faker->dateTimeBetween('-100 days', '-51 days'));
            $event->setEndTime($faker->dateTimeBetween('-50 days', '-1 days'));
            $randomIndex = rand(0, count($categoryNamesToAdd)-1);
            $event->setCategory($category[$randomIndex]);
            $manager->persist($event);
        }

        for ($i = 0; $i < 50; ++$i) {
            $contact = new Contact();
            $contact->setFirstName($faker->firstName);
            $contact->setLastName($faker->lastName);
            $contact->setEmail($faker->email);
            $contact->setPhoneNumber($faker->phoneNumber);
            $manager->persist($contact);
        }

        $manager->flush();
    }
}
