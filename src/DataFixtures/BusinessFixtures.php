<?php


namespace App\DataFixtures;


use App\Entity\Business;
use App\Entity\City;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BusinessFixtures extends Fixture implements DependentFixtureInterface
{
    private $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $faker = Factory::create('fr_FR');
            $business = new Business();
            $businessName = $faker->name;
            $businessSlug = $this->slugify->slugify($businessName);
            /** @var City $city */
            $city = $this->getReference(CityFixtures::TOWN_FR_REFERENCE . $faker->randomElement([0, 1, 2, 3, 4, 5, 6]));
            /** @var User $user */
            $user = $this->getReference(UserFixtures::USER_REFERENCE.$i);
            $user->addBusiness($business);
//            $user = $this->getReference(UserFixtures::USER_REFERENCE . $faker->randomElement([1, 2, 3, 4, 5]));
            $business
                ->setName($businessName)
                ->setAddress($faker->address)
                ->setUser($user)
                ->setPhoneNumber($faker->phoneNumber)
                ->setCity($city)
                ->setSlug($businessSlug)
                ;
            $manager->persist($business);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CityFixtures::class,
            UserFixtures::class
        ];
    }
}