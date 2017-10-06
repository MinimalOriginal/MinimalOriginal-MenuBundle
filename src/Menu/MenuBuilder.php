<?php

namespace MinimalOriginal\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

use Doctrine\Common\Collections\Collection;

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
            $this->addChildren($rootMenu, $menu->getChildren());
          }
        }

        return $rootMenu;
    }
    protected function addChildren(ItemInterface $menu, Collection $children){

      foreach( $children as $child ){
        if( null !== ($routing = $child->getRouting()) ){
          $children_menu = $menu->addChild($child->getTitle(),array(
            'route' => $routing->getRoute(),
            'routeParameters' => $routing->getRouteParams(),
          ));
        }elseif( null !== $child->getUrl() ){
          $children_menu = $menu->addChild($child->getTitle(),$child->getUrl());
        }else{
          Continue;
        }
        if( null !== $child->getChildren() && $child->getChildren()->count() > 0 ){
          $this->addChildren($children_menu, $child->getChildren());
        }

      }

    }
}
