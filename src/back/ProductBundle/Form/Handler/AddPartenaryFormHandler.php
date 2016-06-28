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

use Entity\EcommerceBundle\Entity\Partenary;
use back\ProductBundle\ModelManager\ProductManager;

/**
 * Add Products form handler.
 * 
 * @package backProductBundle
 * @author  Amal Hsouna
 */
class AddPartenaryFormHandler
{

    /**
     * @var FormInterface
     */
    protected $form;
    
    /**
     * @var ProductManager
     */
    protected $productManager;

    /**
     * Constructor class.
     * 
     * @param ProductManager      $productManager  The Product Manager.
     */
    public function __construct(FormInterface $form, ProductManager $productManager)
    {   
        $this->form = $form;
        $this->productManager = $productManager;
       
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
        
        $partenary = new Partenary();
        
        $this->form->setData($partenary);
        if ('POST' == $request->getMethod())
        {
            $this->form->handleRequest($request);
            if ($this->form->isValid())
            {
                $this->productManager->postPartenaryDeals($partenary);
                return $process = true;
                
            }
        }
        return $process;
         
    }

}