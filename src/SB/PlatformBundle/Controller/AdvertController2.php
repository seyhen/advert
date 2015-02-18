<?php

    namespace SB\PlatformBundle\Controller;

    use SB\PlatformBundle\Entity\Advert;
    use SB\PlatformBundle\Form\AdvertEditType;
    use SB\PlatformBundle\Form\AdvertType;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * This class allow to manage advert by Creating Reading Updating and Deleting
     *
     * Class AdvertController
     *
     * @package SB\PlatformBundle\Controller
     */
    class AdvertController extends Controller
    {
        /**
         * Retrieve all adverts from the database, and display in index page
         *
         * @param $page
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function indexAction($page)
        {
            if ($page < 1) {
                throw new NotFoundHttpException('Page "' . $page . '" inexistante.');
            }
            $listAdverts = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('SBPlatformBundle:Advert')
                                ->findAll();

            return $this->render('SBPlatformBundle:Advert:index.html.twig', array(
                'listAdverts' => $listAdverts,
                'page'        => $page
            ));
        }

        /**
         * Display an advert with all informations in a view page
         *
         * @param $id
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function viewAction($id)
        {
            $em     = $this->getDoctrine()->getManager()->getRepository('SBPlatformBundle:Advert');
            $advert = $em->find($id);
            if ($advert == null) {
                throw $this->createNotFoundException("L'annonce " . $id . " n'existe pas");
            }

            return $this->render('SBPlatformBundle:Advert:view.html.twig', array(
                'advert' => $advert
            ));
        }

        /**
         * Call a the formbuilder, when the user submit the form it adds the advert in the database
         *
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         */
        public function addAction(Request $request)
        {
            $advert      = new Advert();
            $formBuilder = $this->get('form.factory')->create(new AdvertType(), $advert);
            if ($formBuilder->handleRequest($request)->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($advert);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'votre annonce a ete enregistré');

                return $this->redirect($this->generateUrl('sb_platform_view', array(
                    'id' => $advert->getId()
                )));
            }

            return $this->render('SBPlatformBundle:Advert:add.html.twig', array(
                'form' => $formBuilder->createView()
            ));
        }

        /**
         * Take an id of an advert, if the advert exist, the function delete the advert from the database
         *
         * @param                                           $id
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         */
        public function deleteAction($id, Request $request)
        {
            $em     = $this->getDoctrine()->getManager();
            $form   = $this->createFormBuilder()->getForm();
            $advert = $em->getRepository('SBPlatformBundle:Advert')->find($id);
            if ($advert == null) {
                throw $this->createNotFoundException("L'annonce " . $id . " n'existe pas");
            }
            if ($form->handleRequest($request)->isValid()) {
                $em->remove($advert);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'Annonce supprimé');

                return $this->redirect($this->generateUrl('sb_platform_homepage'));
            }

            return $this->render('SBPlatformBundle:Advert:delete.html.twig', array(
                'form'   => $form->createView(),
                'advert' => $advert
            ));
        }

        /**
         * Call the formbuilder with informations about the advert prefilled, the user can update the advert selected
         *
         * @param                                           $id
         * @param \Symfony\Component\HttpFoundation\Request $request
         *
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
         */
        public function editAction($id, Request $request)
        {
            $em     = $this->getDoctrine()->getManager();
            $advert = $em->getRepository('SBPlatformBundle:Advert')->find($id);
            if (null === $advert) {
                throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
            }
            $formBuilder = $this->get('form.factory')->create(new AdvertEditType(), $advert);
            if ($formBuilder->handleRequest($request)->isValid()) {
                $em->persist($advert);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'votre annonce a ete enregistré');

                return $this->redirect($this->generateUrl('sb_platform_view', array(
                    'id' => $advert->getId()
                )));
            }

            return $this->render('SBPlatformBundle:Advert:edit.html.twig', array(
                'form'   => $formBuilder->createView(),
                'advert' => $advert
            ));
        }

        /**
         * Create a menu with adverts order by date added
         *
         * @param $limit
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function menuAction($limit)
        {
            $em          = $this->getDoctrine()->getManager();
            $listAdverts = $em->getRepository('SBPlatformBundle:Advert')->findBy(
                array(),
                array('date' => 'desc'),
                $limit,
                0
            );

            return $this->render('SBPlatformBundle:Advert:menu.html.twig', array(
                'listAdverts' => $listAdverts
            ));
        }
    }