<?php

namespace AGEPE\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmployeeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('sexe','choice', array('choices'=>array('MALE'=>'MALE','FEMALE'=> 'FEMALE')))
            ->add('adresse')
            ->add('phoneNumbre')
            ->add('identificationType','choice',array('choices'=>array('CIN'=>'CIN','PASSPORT'=>'PASSPORT')))
            ->add('identificationNumbre')
            ->add('joinDate','date')
            ->add('departureDate','date')
            ->add('contractType','choice',array('choices'=>array('MONTHLY'=>'MONTHLY','DAILY'=>'DAILY','HOURLY'=>'HOURLY')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AGEPE\AdminBundle\Entity\Employee'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'agepe_adminbundle_employee';
    }
}
