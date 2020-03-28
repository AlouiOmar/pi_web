<?php
/**
 * Created by PhpStorm.
 * User: Aloui Omar
 * Date: 03/24/2020
 * Time: 23:07
 */

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileType extends  AbstractType
{
    /**
     * @var string
     */
    private $class;



    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom',null, array('constraints' => [new NotBlank(),]))
            ->add('prenom',null, array('constraints' => [new NotBlank(),]))
            ->add('age',null, array('constraints' => [new NotBlank(),]))
            ->add('telephone',null, array('constraints' => [new NotBlank(),]))
            ->add('photo', FileType::class, array('required'=>true,'data_class' => null))
            ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle','constraints' => [new NotBlank(),]))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle','constraints' => [new NotBlank(),]))
        ;
//        $this->buildUserForm($builder, $options);
//
//        $constraintsOptions = array(
//            'message' => 'fos_user.current_password.invalid',
//        );
////
////        if (!empty($options['validation_groups'])) {
////            $constraintsOptions['groups'] = array(reset($options['validation_groups']));
////        }
//
//        $builder->add('current_password', PasswordType::class, array(
//            'label' => 'form.current_password',
//            'translation_domain' => 'FOSUserBundle',
//            'mapped' => false,
//            'constraints' => array(
//                new NotBlank(),
//                new UserPassword($constraintsOptions),
//            ),
//            'attr' => array(
//                'autocomplete' => 'current-password',
//            ),
//        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'csrf_token_id' => 'profile',
        ));
    }

    // BC for SF < 3.0

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fos_user_profile';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
        ;
    }

}