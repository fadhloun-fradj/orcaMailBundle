<?php

namespace Orca\MailBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MailTblRegleFrequenceAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id',null,array(
                'label'=>'Regle frequence'
            ))
            ->add('regleFrequenceLib',null,array(
                'label'=>'Regle frequence lib'
            ))
            ->add('regleFrequenceDelai',null,array(
                'label'=>'Regle frequence delai'
            ))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id',null,array(
                'label'=>'Regle frequence'
            ))
            ->add('regleFrequenceLib',null,array(
                'label'=>'Regle frequence lib'
            ))
            ->add('regleFrequenceDelai',null,array(
                'label'=>'Regle frequence delai'
            ))
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
//            ->add('id',null,array(
//                'label'=>'Regle frequence'
//            ))
            ->add('regleFrequenceLib',null,array(
                'label'=>'Regle frequence lib'
            ))
            ->add('regleFrequenceDelai',null,array(
                'label'=>'Regle frequence delai'
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('regleFrequenceLib')
            ->add('regleFrequenceDelai')
        ;
    }
}
