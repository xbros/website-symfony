<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class SimonMusicType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Track Name' 
                ))
            ->add('date', DateType::class, array(
                'data' => new \Datetime
                ))
            ->add('pathMp3', FileType::class, array(
                'required' => false,
                'label' => 'mp3 file',
                'data_class' => null
                ))
            ->add('pathImg', FileType::class, array(
                'required' => false,
                'label' => 'img file',
                'data_class' => null
                ))
            ->add('linkSite', ChoiceType::class, array(
                'choices' => array(
                    'soundcloud' => 'SoundCloud',
                    'other' => 'Other',
                    ),
                'placeholder' => 'Link Site',
                'required' => false,
                'empty_data' => null
                ))
            ->add('linkUrl', UrlType::class, array(
                'required' => false,
                'empty_data' => null
                ))
            ->add('save', SubmitType::class, array('label' => 'Submit'))
            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\SimonMusic'
        ));
    }
}
