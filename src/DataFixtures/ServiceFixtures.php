<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getServiceData() as [$name, $expiration, $price]) {
            $service = new Service();
            $service->setName($name);
            $service->setExpirationDate($expiration);
            $service->setPrice($price);

            $manager->persist($service);
        }
        $manager->flush();
    }

    private function getServiceData()
    {
        return [
            ['Skelbimai',
                30,
                15,
                1
            ],
            ['Baneriai',
                60,
                25,
                2
            ],
        ];
    }
}
