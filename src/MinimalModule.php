<?php

namespace MinimalOriginal\MenuBundle;

use MinimalOriginal\CoreBundle\Modules\AbstractManageableModule;

use MinimalOriginal\MenuBundle\Form\MenuType;
use MinimalOriginal\MenuBundle\Entity\Menu;

class MinimalModule extends AbstractManageableModule{

  /**
   * {@inheritdoc}
   */
  public function init(){
    $this->informations->set('name', 'menu');
    $this->informations->set('title', 'Menus');
    $this->informations->set('description', "Créez ou modifiez les menus de votre site.");
    $this->informations->set('icon', "ion-ios-list-outline");
    return $this;
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
