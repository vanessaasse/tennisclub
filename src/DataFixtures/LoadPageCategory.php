<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\PageCategory;

class LoadPageCategory extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Liste des noms de catégorie à ajouter
        $names = array(
            "Le club",
            "L'école de tennis",
            "Tennis club",
            "Compétitions"
        );

        foreach ($names as $name) {
            // On crée la catégorie
            $pageCategory = new PageCategory();
            $pageCategory->setName($name);

            // On la persiste
            $manager->persist($pageCategory);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}