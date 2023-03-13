<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Contact;
use Faker\Factory;
use Faker\Generator;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
        $this->faker = Factory::create('fr FR');
    }

    public function load(ObjectManager $manager): void
    {
        // Users
        $users = [];

        $user = new User();
        $user->setEmail('lolissr@contact.com');
        $user->setName('admin');
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'azerty'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++)
        {
            $user = new User();
            $user->setEmail($this->faker->email());
            $user->setName($this->faker->name());
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'azerty'));
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);

            $users[] = $user;
            $manager->persist($user);
        }

        // Contacts
        $contacts = [];

        for ($i = 1; $i <= 20; $i++)
        {
            $contact = new Contact();
            $contact->setEmail($this->faker->email());
            $contact->setName($this->faker->name());
            $contact->setSubject($this->faker->text(10));
            $contact->setMessage($this->faker->text(300));
            $contact->setUser($users[mt_rand(0, count($users) -1)]);

            $contacts[] = $contact;
            $manager->persist($contact);
        }

        $manager->flush();
    }
}