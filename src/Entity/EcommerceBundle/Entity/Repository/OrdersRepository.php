<?php
/**
 * OrdersRepository
 * 
 * @package EntityEcommerceBundle
 * @author Amal Hsouna
 */

namespace Entity\EcommerceBundle\Entity\Repository;

/**
 * OrdersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrdersRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Finds all Products.
     * 
     * @return array
     */
    public function findByCustomer($customer)
    {
        $listOrders = $this->find($customer);
        return $listOrders;
    }
}
