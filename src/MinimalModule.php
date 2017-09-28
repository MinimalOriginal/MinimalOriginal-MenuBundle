<?php

namespace MinimalOriginal\MenuBundle;

use MinimalOriginal\CoreBundle\Modules\ModuleInterface;
use Doctrine\ORM\EntityManager;

use MinimalOriginal\MenuBundle\Form\MenuType;
use MinimalOriginal\MenuBundle\Entity\Menu;

class MinimalModule implements ModuleInterface{

  private $moduleList;

  protected $em;

  public function __construct(EntityManager $em)
  {
      $this->em = $em;
  }

  /**
   * {@inheritdoc}
   */
  public function getName(){
    return 'menu';
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle(){
    return "Menus";
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription(){
    return "Créez ou modifiez les menus de votre site.";
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityClass(){
    return Menu::class;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormTypeClass(){
    return MenuType::class;
  }

}
