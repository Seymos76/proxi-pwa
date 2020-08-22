<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const USER_REFERENCE = 'user_';
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $plainPassword = 'password';
            $encodedPassword = $this->encoder->encodePassword($user, $plainPassword);
            $user->setEmail("user$i@proxi.local")->setRoles(['ROLE_USER'])->setPassword($encodedPassword);
            $faker = Factory::create('fr_FR');
            $this->setReference(self::USER_REFERENCE . $i, $user);
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CityFixtures::class
        ];
    }
}
