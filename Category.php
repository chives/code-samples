<?php

namespace Adevo\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="Adevo\NewsBundle\Repository\CategoryRepository")
 * @ORM\Table(name="news_categories")
 */
class Category extends AbstractTaxonomy {
    
    /**
     * @ORM\OneToMany(
     *      targetEntity = "Post",
     *      mappedBy = "category"
     * )
     */
    protected $posts;
    
    
}