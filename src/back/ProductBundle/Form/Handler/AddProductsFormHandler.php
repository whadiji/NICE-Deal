<?php

/**
 * backProductBundle form handler.
 * 
 * @package backProductBundle
 * @author Amal Hsouna
 */

namespace back\ProductBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

use Entity\EcommerceBundle\Entity\Products;
use back\ProductBundle\ModelManager\ProductManger;

/**
 * Add Products form handler.
 * 
 * @package backProductBundle
 * @author  Amal Hsouna
 */
class AddProductsFormHandler
{

    /**
     * @var FormInterface
     */
    protected $form;
    
    /**
     * @var ProductManger
     */
    protected $productManger;

    /**
     * Constructor class.
     * 
     * @param Registry           $doctrine  The doctrine.
     * @param FormInterface      $form  The form interface.
     * @param ProductManger      $productManger  The Product Manger.
     */
    public function __construct(Registry $doctrine, FormInterface $form, ProductManger $productManger)
    {   
        $this->doctrine = $doctrine;
        $this->entityManagerProducts = $doctrine->getManager();
        $this->form = $form;
        $this->productManger = $productManger;
       
    }

    /**
     * The process function for handler.
     * 
     * @param Request $request The current request.
     * 
     * @return $response
     */
    public function process(Request $request)
    {
        $process  = false;
        
        $products = new Products();
                
        $this->form->setData($products);
        if ('POST' == $request->getMethod())
        {
            $this->form->handleRequest($request);
            if ($this->form->isValid())
            {
                return $this->productManger->saveProducts($products);
            }
        }
        return false;
         
    }

}
