<?php

namespace MinimalOriginal\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

use MinimalOriginal\CoreBundle\Entity\Routing;
use MinimalOriginal\CoreBundle\Annotation\Exposure;

/**
 * Menu
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 */
class Menu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Exposure(groups = {"manager"}, name = "Titre")
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"}, updatable=false, separator="-")
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="MinimalOriginal\CoreBundle\Entity\Routing")
     * @ORM\JoinColumn(name="routing_id", referencedColumnName="id", nullable=true)
     */
     private $routing;

     /**
      * @var string
      *
      * @ORM\Column(name="url", type="string", length=255, nullable=true)
      */
     private $url;


    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Menu")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    public function __toString(){
      return $this->getTitle();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Menu
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        if( null === $this->title && null !== $this->getRouting()){
          return $this->getRouting()->__toString();
        }
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Menu
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set routing
     *
     * @param Routing $routing
     *
     * @return Menu
     */
    public function setRouting(Routing $routing)
    {
        $this->routing = $routing;

        return $this;
    }

    /**
     * Get routing
     *
     * @return Routing
     */
    public function getRouting()
    {
        return $this->routing;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Menu
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get created date
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get updated date
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Get root page
     *
     * @return null|Page
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Get set parent page
     *
     * @param null|Page $parent
     *
     */
    public function setParent(Menu $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent page
     *
     * @return null|Page
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Return children
     *
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
