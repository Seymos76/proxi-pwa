<?php


namespace App\DataFixtures;


use App\Entity\Business;
use App\Entity\City;
use App\Entity\TimeTable;
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
//            $businessTimeTable = $this->createTimeTable();
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

    private function createTimeTable(): TimeTable
    {
        $timeTable = new TimeTable();
        return $timeTable->setDay(TimeTable::MONDAY)
            ->setDayPart(TimeTable::AM)
            ->setOpeningTime(new \DateTime('08:00'))
            ->setClosingTime(new \DateTime('18:30'))
        ;
    }

    private function getBisDate(string $time)
    {
        /** @example $date = date(string format, strtotime); */
        return date('d/m/Y',strtotime("20-09-2020 $time"));
    }

    private function getDateWithTime()
    {
        /** @example $time = strtotime('20-09-2020 21:00'); */
        $time = strtotime('20-09-2020 21:00');
        /** @example $date = date(string format, strtotime); */
        $date = date('d/m/Y H:i',strtotime('20-09-2020 21:00'));
    }

    public function getDependencies(): array
    {
        return [
            CityFixtures::class,
            UserFixtures::class
        ];
    }
}