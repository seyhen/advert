<?php
/**
 * Created by PhpStorm.
 * User: alexandre.an
 * Date: 01/10/2014
 * Time: 14:49
 */

namespace SB\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SB\PlatformBundle\Entity\Category;

class LoadCategory implements  FixtureInterface{

    public function load(ObjectManager $manager)
    {
        $names = array(
            'Développement web',
            'Développement mobile',
            'Graphisme',
            'Intégration',
            'Réseau'
        );

        foreach ($names as $name) {
            // On crée la catégorie
            $category = new Category();
            $category->setName($name);

            // On la persiste
            $manager->persist($category);
        }

        // On déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
} 