<?php


namespace App\DataFixtures;


use App\Entity\BusinessCategory;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BusinessCategoryFixtures extends Fixture
{
    private Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Alimentation',
            'Art',
            'Artisan',
            'Bar',
            'Beauté & santé',
            'Culture',
            'Loisirs',
            'Maison & déco',
            'Marché',
            'Mode',
            'Multimédia',
            'Restauration',
            'Véhicule'
        ];
        $categoriesCount = count($categories);
        for ($i = 0; $i < $categoriesCount; $i++) {
            $businessCategory = new BusinessCategory();
            $slug = $this->slugify->slugify($categories[$i]);
            $businessCategory->setName($categories[$i])->setSlug($slug);
            $this->setReference("business_category_$i", $businessCategory);
            $manager->persist($businessCategory);
        }
        $manager->flush();
    }
}