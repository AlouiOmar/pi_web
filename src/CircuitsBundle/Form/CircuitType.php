<?php

namespace CircuitsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CircuitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('depart',
                EntityType::Class,array(
                    'class'=>"CircuitsBundle:Station",
                    'choice_label'=>'nom',
                    'multiple'=>false))
            ->add('pause',
                EntityType::Class,array(
                    'class'=>"CircuitsBundle:Station",
                    'choice_label'=>'nom',
                    'multiple'=>false))
            ->add('end',
                EntityType::Class,array(
                    'class'=>"CircuitsBundle:Station",
                    'choice_label'=>'nom',
                    'multiple'=>false))
            ->add('difficulty')
            ->add('distance')
            ->add('Save',SubmitType::class,array('label'=>'Ajouter','attr'=> array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CircuitsBundle\Entity\Circuit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'circuitsbundle_circuit';
    }


}
