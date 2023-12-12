<?php

namespace App\DataFixtures;

use App\Entity\Products;
use App\ValueObject\ProductId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 20; $i++) {
            $product = new Products();
            $product->setId(ProductId::fromMixed(uuid_create(UUID_TYPE_RANDOM)));
            $product->setName($faker->word);
            $product->setPrice($faker->randomFloat(2, 10, 100));
            $product->setDescription($faker->realText($maxNbChars = 100, $indexSize = 2));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
