<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Comment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private PasswordHasherFactoryInterface $passwordHasherFactory
    )
    {

    }

    public function load(ObjectManager $manager): void
    {
        $nalchik = new Conference();
        $nalchik->setCity('Nalchik');
        $nalchik->setYear('2023');
        $nalchik->setIsInternational(false);
        $manager->persist($nalchik);

        $moskva = new Conference();
        $moskva->setCity('Москва');
        $moskva->setYear('2021');
        $moskva->setIsInternational(true);
        $manager->persist($moskva);

        $comment1 = new Comment();
        $comment1->setConference($moskva);
        $comment1->setAuthor('Kelly');
        $comment1->setEmail('kelly@mail.com');
        $comment1->setText('This was a great conference!');
        $comment1->setState('published');
        $manager->persist($comment1);

        $comment2 = new Comment();
        $comment2->setConference($moskva);
        $comment2->setAuthor('Lucas');
        $comment2->setEmail('lucas@mail.ru');
        $comment2->setText('Thank`s!');
        $manager->persist($comment2);

        $admin = new Admin();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword($this->passwordHasherFactory->getPasswordHasher(Admin::class)->hash('admin'));
        $manager->persist($admin);

        $manager->flush();
    }
}
