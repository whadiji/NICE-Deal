<?php

/**
 * ProductsRepository
 * 
 * @package EntityEcommerceBundle
 * @author Amal Hsouna
 */

namespace Entity\EcommerceBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Entity\EcommerceBundle\Entity\Products;

/**
 * ProductsRepository
 *
 * This class was generated by the findProductsByIdDoctrine ORM. Add your products
 * repository methods below.
 * @package EntityEcommerceBundle
 * @author  Amal Hsouna
 */
 
class ProductsRepository extends EntityRepository
{
    /**
     * Finds all Products.
     * 
     * @return array
     */
    public function findAllProducts()
    {
        $listProducts = $this->findAll();
        return $listProducts;
    }
    
    /**
     * Persists Product.
     * 
     * @param Products $products The products model.
     * 
     * @return void
     */
    public function saveProducts(Products $products)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($products);
        $entityManager->flush();
    }
    
    /**
     * Finds Product by id.
     * 
     * @return array
     */
    public function findProductsById($id)
    {
        $products = $this->findOneById($id);

        return $products;
    }
    
    /**
     * delete Product.
     *
     * @return true.
     */
    public function delete(Products $product)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($product);
        $entityManager->flush();
    }
    
    /**
     * Finds Products with the date has passed.
     * 
     * @return array
     */
    public function findProductsByEndDate()
    {
          
        $query = $this->_em->createQuery('SELECT p FROM EntityEcommerceBundle:Products p where p.endDate <  CURRENT_DATE()');
        $resultsQuery = $query->getResult();

        return $resultsQuery;   
  
    }
    
    /* Finds category by name.
     * 
     * @param $nameCategory name of category
     * 
     * @return array
     */
    public function findProductByCategory($nameCategory)
    {   
        $queryBuilder = $this->createQueryBuilder('p')
                      ->leftJoin('p.category', 'c')
                      ->where('p.category = c.id')
                      ->andWhere('c.name  = :category')
                      ->setParameter('category', $nameCategory)
                      ->getQuery()
                      ->getResult();

        return $queryBuilder;  
    }
    
    /**
     * Finds product by city.
     * 
     * @param $city The city of product
     * 
     * @return array
     */
    public function findProductByCity($city)
    {
        $productsByCity = $this->findByPlace($city);

        return $productsByCity;
    }
    
    /* Finds product by date.
     * 
     * @return array
     */
    public function findProductByDate()
    {   
       $query = $this->_em->createQuery('SELECT COUNT(p) FROM EntityEcommerceBundle:Products p where p.endDate > =  CURRENT_DATE()');
       $resultsQuery = $query->getResult();

       return $resultsQuery;   
    }
}