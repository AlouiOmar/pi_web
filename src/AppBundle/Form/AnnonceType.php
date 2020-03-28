<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;



class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('categorie', ChoiceType::class, [
                'attr'=>['onclick'=>'sweet1()','class'=>'b'],
                'choices'  => [
                    'Vélo' => 'Vélo',
                    'Pièce de rechange' => 'Pièce de rechange',
                    'Accessoire' => 'Accessoire',
                ],
            ])
            ->add('gouvernorat', ChoiceType::class, [
                'choices'  => [
                    'Ariana' => 'Ariana',
                    'Béja' => 'Béja',
                    'Ben Arous' => 'Ben Arous',
                    'Bizerte' => 'Bizerte',
                    'Gabès' => 'Gabès',
                    'Gafsa' => 'Gafsa',
                    'Jendouba' => 'Jendouba',
                    'Kairouan' => 'Kairouan',
                    'Kasserine' => 'Kasserine',
                    'Kébili' => 'Kébili',
                    'Le Kef' => 'Le Kef',
                    'Mahdia' => 'Mahdia',
                    'La Manouba' => 'La Manouba',
                    'Médenine' => 'Médenine',
                    'Monastir' => 'Monastir',
                    'Nabeul' => 'Nabeul',
                    'Sfax' => 'Sfax',
                    'Sidi Bouzid' => 'Sidi Bouzid',
                    'Siliana' => 'Siliana',
                    'Sousse' => 'Sousse',
                    'Tataouine' => 'Tataouine',
                    'Tozeur' => 'Tozeur',
                    'Tunis' => 'Tunis',
                    'Zaghouan' => 'Zaghouan',
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Vente' => 'Vente',
                    'Location' => 'Location',
                ],
            ])
            ->add('description',TextareaType::class)
            ->add('prix')
            ->add('photo',FileType::class
                , array('data_class' => null,'constraints' => [
                    new NotBlank(),
                ])
            )
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
                'attr' => array('class' => 'js-datepicker', 'style' => 'line-height: 20px;'),
                'html5' => false,
            ))
//            ->add('datep')
            ->add('active')
            ->add('typevelo',ChoiceType::class,['attr'=>['class'=>'k'],
                'choices'  => [
                    'Tout chemin' => 'Tout chemin',
                    'Hollandais' => 'Hollandais',
                    'Tout terrain' => 'Tout terrain',
                    'Enfant' => 'Enfant',
                    'Course' => 'Course',
                    'Pliant' => 'Pliant',
                    'Couché' => 'Couché',
                    'Remorques' => 'Remorques',


                ],])
            ->add('couleur',TextType::class,['attr'=>['class'=>'k']])
//            ->add('idu')


        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Annonce'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_annonce';
    }


}
