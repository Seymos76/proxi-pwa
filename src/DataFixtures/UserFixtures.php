<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $plainPassword = 'password';
            $encodedPassword = $this->encoder->encodePassword($user, $plainPassword);
            $user->setEmail("user$i@proxi.local")->setRoles(['ROLE_USER'])->setPassword($encodedPassword);
            $manager->persist($user);
        }
        $manager->flush();
    }
}