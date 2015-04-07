<?php
    namespace SB\PlatformBundle\DataFixtures\ORM;
    use Doctrine\Common\DataFixtures\FixtureInterface;
    use Doctrine\Common\Persistence\ObjectManager;
    use Symfony\Component\DependencyInjection\ContainerAwareInterface;
    use Symfony\Component\DependencyInjection\ContainerInterface;




    class LoadUsersData implements FixtureInterface, ContainerAwareInterface
    {
        /**
         * @var ContainerInterface
         */
        private $container;
        /**
         * {@inheritDoc}
         */
        public function setContainer(ContainerInterface $container = null) {
            $this->container = $container;
        }
        public function load(ObjectManager $manager)
        {
            $userManager = $this->container->get('fos_user.user_manager');
            $userAdmin = $userManager->createUser();
            $userAdmin->setUsername('seyhen')
                      ->setEmail('seyhen@gmail.com')
                      ->setPlainPassword('seyhen')
                      ->setEnabled(true)
                      ->setSuperAdmin(true);
            $manager->persist($userAdmin);
            $manager->flush();
        }
    }