<?php

namespace ProductBundle\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;
class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomP')
            ->add('typeP',
                EntityType::Class,array(
                    'class'=>"ProductBundle:Typeproduit",
                    'choice_label'=>'libelleTp',
                    'multiple'=>false))
            ->add('marqueP')
            ->add('categorieP')
            ->add('couleurP')
            ->add('prixP')
            ->add('tel')
            ->add('imageName',FileType::class,[
                'mapped'=> false,
                'label' =>'Joindre un photo '
            ])
            ->add('captcha', CaptchaType::class, array(
                'width' => 200,
                'height' => 50,
                'length' => 6,
            ))
            ->add('Save',SubmitType::class,array('label'=>'Ajouter','attr'=> array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')));


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productbundle_produit';
    }


}
