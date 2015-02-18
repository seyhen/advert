<?php

namespace SB\PlatformBundle\Form;

use Sluggable\Fixture\Issue827\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdvertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date',array('widget' =>'single_text',
                'format' =>'dd/MM/yyyy'))
            ->add('title', 'text')
            ->add('author', 'text')
            ->add('content', 'textarea')
            ->add('image', new ImageType(), array('required'=>false))
            ->add('categories', 'entity', array(
                'class' => 'SBPlatformBundle:Category',
                'property' => 'name',
                'multiple' => true
            ))
            ->add('save', 'submit')
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event)
            {
                $advert = $event->getData();
                if (null === $advert)
                    return null;

                if (!$advert->getPublished() || null == $advert->getId())
                {
                    $event->getForm()->add('published', 'checkbox', array('required'=>false));
                }
                else
                {
                    $event->getForm()->remove('published');
                }
            }
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SB\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sb_platformbundle_advert';
    }
}
