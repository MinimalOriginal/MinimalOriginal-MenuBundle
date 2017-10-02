<?php

namespace MinimalOriginal\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

use MinimalOriginal\MenuBundle\Entity\Menu;
use MinimalOriginal\CoreBundle\Modules\ModuleList;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    private $moduleList;

    /**
    * @param FactoryInterface $factory
    */
    public function __construct(FactoryInterface $factory)
    {
      $this->factory = $factory;
    }

    /**
    * @param ModuleList $moduleList
    */
    public function setModuleList(ModuleList $moduleList){
      $this->moduleList = $moduleList;
    }

    public function createMenu(array $options)
    {
        $em = $this->container->get('doctrine')->getManager();
        $repo = $em->getRepository(Menu::class);
        $rootMenu = $this->factory->createItem('root')
        ->setChildrenAttribute('class', 'menu dropdown')
        ->setChildrenAttribute('data-dropdown-menu', true);

        if( true === isset($options['root']) ){
          if( null !== ($menu = $repo->findOneBySlug($options['root'])) ){

            foreach( $menu->getChildren() as $child ){
              if( null !== ($routing = $child->getRouting()) ){
                $rootMenu->addChild($routing->getTitle(),array(
                  'route' => $routing->getRoute(),
                  'routeParameters' => $routing->getRouteParams(),
                ));
              }elseif( null !== $child->getUrl() ){
                $rootMenu->addChild($child->getTitle(),$child->getUrl());
              }else{
                Continue;
              }

            }

          }
        }

        return $rootMenu;
    }
}
