<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageCategoryRepository")
 *
 */
class PageCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=190)
     */
    private $slug;

    /**
     * @var Page[]\ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="pageCategory", cascade={"persist"})
     */
    private $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }



    /**
     * add Page
     * @param Page $page
     * @return PageCategory
     */
    public function addPage(\App\Entity\Page $page)
    {
        $this->pages[] = $page;
        $page->setPageCategory($this);

        return $this;
    }


    /**
     * Remove Page
     * @param Page $page
     * @return bool
     */
    public function removePage(\App\Entity\Page $page)
    {
        return $this->pages->removeElement($page);
    }


    /**
     * Get Pages
     * @return Page[]|ArrayCollection
     */
    public function getPages()
    {
        return $this->pages;
    }

}
