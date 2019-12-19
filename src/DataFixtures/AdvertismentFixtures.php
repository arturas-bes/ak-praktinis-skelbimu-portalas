<?php

namespace App\DataFixtures;

use App\Entity\Advertisment;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AdvertismentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getBlogPostData() as [$title, $subject, $image, $author]) {
            $auth = $manager->getRepository(User::class)->find($author);
            $post = new Advertisment();

            $post->setTitle($title);
            $post->setSubject($subject);
            $post->setImagePath($image);
            $post->setImageTitle('title');
            $post->setAuthor($auth);
            $manager->persist($post);
        }
        $manager->flush();
    }

    public function getBlogPostData()
    {
        return [
            [
                'Naujas,kokybiškai pastatytas, gražus namas',
                'Parduodamas prabangus, grazus, tvarkingas namas šalia Klaipėdos, prie jau veikiančio golfo aikštyno, vaizdingoje „National Golf Resort“ teritorijoje, ramioje gražioje vietoje, naujame kvartale. Yra įkurta kvartalo bendrija, aptverta teritorija su automatiniais įvažiavimo metaliniais vartais, asfaltuotos gatvės, įrengtas apšvietimas, yra dujotiekis, vandentiekis, kanalizacija. Į namą įvestas vandentiekis ir kanalizacija, pajungta lietaus kanalizacija. Namas statytas kokybiškai, be vidaus apdailos su pilna fasado apdaila, langais bei durimis. Sklypo teritorija aptverta, apželdinta, pasodinti vaismedžiai. Kaina yra derinama, Kaina 175 000 eur Tel nr : 123456789',
                '/uploads/advertisment/images/namas.jpg',
                1
            ],
            [
                ' Internetinių svetainių kūrimas tik 99 eur!',
                'okybiška, funkcionali ir vizualiai patraukli internetinė svetainė - kelias į Jūsų verslo ar versliuko sėkmę!
Sukursiu internetinę svetainę (ar internetinę parduotuvę), kuri bus saugi, moderni ir lengvai valdoma, atitiks moderniausias dizaino tendencijas, bus pritaikyta naudoti mobiliaisiais įrenginiais, optimizuota paieškos sistemoms.

Baigus darbus pamokysiu kaip naudotis ir lengvai keisti turinį.

Internetinės svetainės kaina 99 Eur.
Internetinės parduotuvės kaina 199 Eur.

O taip pat nemokamai:

- sukursiu nesudėtingą minimalistinį logotipą
- užregistruosiu domeną
- patalpinsiu Jūsų svetainę internete
- sukursiu elektroninį paštą
- konsultuosiu 3 mėn. po internetinės svetainės sukūrimo!

Susidomėjusiems atsiųsiu savo atliktų darbų pavyzdžius.


+370 621 14242',
                '/uploads/advertisment/images/svetaine.jpg',
                2
            ],
            [
                'Dodge Grand Caravan, 3.3 l., vienatūris, 2005',
                'Tvarkingas automobilis, sutvarkyta važiuoklė, gale papildomos lingės, restauruota vairo kolonėlė, pakeistas generatoriaus diržas ir įtempimo guolis, padarytas ratų suvedimas, kablys, el. langai ir veidrodėliai, radijas, CD grotuvas, autopilotas, lieti ratlankiai, automatinė dėžė ir variklis veikia puikiai, kita tech. apžiūra 2020.04 Kaina 1500 EUR Tel nr: 869937750',
                '/uploads/advertisment/images/masina.jpg',
                1
            ],
        ];

    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
