<?php

namespace Entity\EcommerceBundle\Entity\Repository;

use Entity\EcommerceBundle\Entity\SubCategory;

/**
 * SubCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubCategoryRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Finds Products with the date has passed.
     * 
     * @return array
     */
    public function findCategory()
    {     
         $queryBuilder = $this->createQueryBuilder('c')
                        ->select("c.subName, s.name")
                        ->leftJoin('c.category', 's')
                        ->where('c.category = s.id')
                        ->getQuery()
                        ->getResult();

        return $queryBuilder;   
  
    }
    
    /**
     * Persists subCategory.
     * 
     * @param subCategory $subCategory The sub category model.
     * 
     * @return void
     */
    public function saveSubCategory(SubCategory $subCategory)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($subCategory);
        $entityManager->flush();
    }
}
