<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; $i++) {
            $product = new Products();
            $product->setName("Product $i");
            $product->setPrice(rand(10, 100));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
