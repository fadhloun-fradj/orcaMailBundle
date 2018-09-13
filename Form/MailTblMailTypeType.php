<?php

namespace Orca\MailBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailTblMailTypeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mailTypeLib',null,array(
                'label'=>'Label',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('mailTypeObjet',null,array(
                'label'=>'Objet',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('mailTypeExpediteur',null,array(
                'label'=>'Expediteur',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('mailTypeCc',null,array(
                'label'=>'CC',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('mailTypeBcc',null,array(
                'label'=>'BCC',
                'attr'=>array('class'=>'form-control')
            ))
            ->add('mailTypeActif',null,array(
                'label'=>'Actif'
            ))
            ->add('mailTypeBody',TextareaType::class,array(
                'attr'=>array('class'=>'form-control','rows'=>10),
                'label'=>'Contenu'
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Orca\MailBundle\Entity\MailTblMailType'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'orca_mailbundle_mailtblmailtype';
    }


}
