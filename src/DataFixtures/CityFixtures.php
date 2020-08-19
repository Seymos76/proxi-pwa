<?php


namespace App\DataFixtures;


use App\Entity\City;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    private $slugger;

    public function __construct(Slugify $slugify)
    {
        $this->slugger = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadFrenchTowns($manager);
        $manager->flush();
    }

    private function loadFrenchTowns(ObjectManager $manager)
    {
        $townsArray = $this->getDecodedArrayFromFile(__DIR__ . "/../../public/data/communes/communes_fr.json");
        // for each region -> create Region and persist
        foreach ($townsArray as $key => $item) {
            $town = new City();
            if (array_key_exists("nom", $item)) {
                $town->setName($item["nom"]);
                $slug = $this->slugger->slugify($item['nom']);
                $town->setSlug($slug);
            }
            if (array_key_exists("code", $item)) {
                $town->setCode($item["code"]);
            }
            if (array_key_exists("codeDepartement", $item)) {
//                /** @var Department $department */
//                $department = $this->getReference(DepartmentFixtures::DEPARTMENT_FR_REFERENCE."_".$item["codeDepartement"]);
                $town->setDepartmentCode($item['codeDepartement']);
            }
            if (array_key_exists("codesPostaux", $item)) {
                if (isset($item['codesPostaux'][0])) {
                    $town->setZipCode($item["codesPostaux"][0]);
                } else {
                    $town->setZipCode($item["code"]);
                }
            }
            if (array_key_exists("population", $item)) {
                $town->setPopulation($item["population"]);
            }
//            $this->addReference(self::TOWN_FR_REFERENCE . "_" . $item["code"], $town);
            $manager->persist($town);
        }
    }

    private function getDecodedArrayFromFile(string $file): array
    {
        $file = file_get_contents($file);
        // parse regions_fr.json to array
        $array = json_decode($file, true);
        return $array;
    }
}