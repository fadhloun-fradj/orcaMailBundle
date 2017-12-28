<?php

namespace Orca\MailBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class MailTblVueAdmin extends AbstractAdmin
{
    public function configureRoutes(RouteCollection $collection){
        $collection->add('showResult',$this->getRouterIdParameter().'/showResult');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('vueLib')
//            ->add('vueSqlPropel')
            ->add('vueSqlRaw')
            ->add('vuePostSqlRaw')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('vueLib',null,array(
                'label'=>'Libellé de la requête'
            ))
            ->add('vueSqlRawLength',null,array(
                'label'=>'Requête SQL'
            ))
//            ->add('vueSqlPropel')
            ->add('vuePostSqlRaw',null,array(
                'label'=>'Requête SQL (post traitement)'
            ))
            ->add('_action', null, [
                'actions' => [
                    'showResult' => [
                        'template' => 'OrcaMailBundle:CRUD:list__action_show_result.html.twig'
                    ],
//                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('vueLib',null,array(
                'label'=>'Libellé de la requête'
            ))
            ->add('vueSqlRaw','textarea',array(
                'label'=>'Requête SQL',
                'attr'=>array('rows'=>'15')
            ))
            ->add('vuePostSqlRaw','textarea',array(
                'label'=>'Requête SQL (post traitement)',
                'attr'=>array('rows'=>'15')
            ))
//            ->add('vueSqlPropel')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('vueLib',null,array(
                'label'=>'Libellé de la requête'
            ))
            ->add('vueSqlRaw',null,array(
                'label'=>'Requête SQL'
            ))
//            ->add('vueSqlPropel')
            ->add('vuePostSqlRaw',null,array(
                'label'=>'Requête SQL (post traitement)'
            ))
        ;
    }


}
