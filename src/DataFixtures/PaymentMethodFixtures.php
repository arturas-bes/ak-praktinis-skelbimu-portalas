<?php

namespace App\DataFixtures;

use App\Entity\PaymentMethod;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PaymentMethodFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getPaymentData() as [$name]) {
            $service = new PaymentMethod();
            $service->setName($name);

            $manager->persist($service);
        }
        $manager->flush();
    }

    private function getPaymentData()
    {
        return [
            ['SEB', 1],
            ['SwedBank', 2],
            ['Luminor', 3],
            ['Paypal', 4]
        ];
    }
}
