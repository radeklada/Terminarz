<?php
/*
 * This file is part of the Terminarz application.
 *
 * (c) Radek Łada <radlad98@gmail.com>
 *
 * For the full copyright and license information, please contact the author.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures.
 */
class UserFixtures extends AbstractBaseFixtures
{
    /**
     * Password encoder.
     *
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     *
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder Password encoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail(sprintf('user@terminarz.local'));
        $user->setRoles([User::ROLE_USER]);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                'user'
            )
        );
        $manager->persist($user);

        $userAdmin = new User();
        $userAdmin->setEmail(sprintf('admin@terminarz.local'));
        $userAdmin->setRoles([User::ROLE_USER, User::ROLE_ADMIN]);
        $userAdmin->setPassword(
            $this->passwordEncoder->encodePassword(
                $userAdmin,
                'admin'
            )
        );
        $manager->persist($userAdmin);

        $manager->flush();

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
            $event->setUser($user);
            $manager->persist($event);
        }

        for ($i = 0; $i < 50; ++$i) {
            $contact = new Contact();
            $contact->setFirstName($faker->firstName);
            $contact->setLastName($faker->lastName);
            $contact->setEmail($faker->email);
            $contact->setPhoneNumber($faker->phoneNumber);
            $contact->setUser($user);
            $manager->persist($contact);
        }

        $manager->flush();
    }
}
