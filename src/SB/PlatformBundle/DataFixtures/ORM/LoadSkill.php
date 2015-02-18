<?php
/**
 * Created by PhpStorm.
 * User: alexandre.an
 * Date: 01/10/2014
 * Time: 16:16
 */

namespace SB\PlatformBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SB\PlatformBundle\Entity\Skill;

class LoadSkill implements FixtureInterface{
    public function load(ObjectManager $manager)
    {
        $names = array('PHP', 'Symfony2', 'C++', 'Java', 'Photoshop', 'Blender', 'Bloc-note');
        foreach($names as $name)
        {
            $skill = new Skill();
            $skill->setName($name);
            $manager->persist($skill);
        }
        $manager->flush();
    }
} 