<?php


namespace App\DataFixtures;


use App\Entity\City;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Serializer\SerializerInterface;

class CityFixtures extends Fixture
{
    public const TOWN_FR_REFERENCE = "city_fr_";
    private $slugger;
    private $serializer;

    public function __construct(Slugify $slugify, SerializerInterface $serializer)
    {
        $this->slugger = $slugify;
        $this->serializer = $serializer;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadFrenchTowns($manager);
        $manager->flush();
    }

    private function loadFrenchTowns(ObjectManager $manager)
    {
        $townsArray = $this->getDecodedArrayFromFile(__DIR__ . "/../../public/data/communes.json");
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
            $this->addReference(self::TOWN_FR_REFERENCE . $key, $town);
            $manager->persist($town);
        }
    }

    private function getDecodedArrayFromFile(string $file)
    {
        $file = file_get_contents($file);
        $json = $this->serializer->deserialize($file, City::class, 'json');
        dump($json);
        // parse regions_fr.json to array
        $array = json_decode($file, true);
        return $array;
    }
}