<?php


namespace App\DataFixtures;


use App\Entity\Business;
use App\Entity\BusinessCategory;
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
    private Slugify $slugify;

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
            /** @var BusinessCategory $businessCategory */
            $businessCategory = $this->getReference("business_category_$i");
            $businessCategory->addBusiness($business);
            $businessTimeTable = $this->createTimeTable('08:30','18:30');
//            $user = $this->getReference(UserFixtures::USER_REFERENCE . $faker->randomElement([1, 2, 3, 4, 5]));
            $business
                ->setName($businessName)
                ->setAddress($faker->address)
                ->setUser($user)
                ->setPhoneNumber($faker->phoneNumber)
                ->setCity($city)
                ->setSlug($businessSlug)
                ->addTimeTable($businessTimeTable)
                ->setBusinessCategory($businessCategory)
                ->setImage('https://p0.pikist.com/photos/530/603/maison-manechal-hautes-pyrenees-france-holidays-pyrenees-architecture-french-toulouse-travel.jpg')
                ;
            $manager->persist($business);
        }
        $manager->flush();
    }

    private function createTimeTable(string $start = null, string $end = null): TimeTable
    {
        $timeTable = new TimeTable();
        return $timeTable->addDay(TimeTable::MONDAY)->addDay(TimeTable::TUESDAY)->addDay(TimeTable::WEDNESDAY)
            ->setOpeningTime(new \DateTime($start))
            ->setClosingTime(new \DateTime($end))
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
            BusinessCategoryFixtures::class,
            UserFixtures::class
        ];
    }
}