<?php

/**
 * Products form type.
 * 
 * @package backProductBundle
 * @author  Amal Hsouna
 */

namespace back\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use back\ProductBundle\Form\Type\ImagesFormType;

/**
 * Products form type.
 * 
 * @package backProductBundle
 * @author Amal Hsouna
 */
class AddProductsFormType extends AbstractType
{

    /**
     * @var string
     */
    protected $class;
    
    /**
     * @var ImagesFormType
     */
    protected $imagesFormType;

    /**
     * Constructor class.
     * 
     * @param string $class  The model for handle form type.
     * @param ImagesFormType $imagesFormType The Images Form Type.
     */
    public function __construct($class, ImagesFormType $imagesFormType)
    {
        $this->class  = $class;
        $this->imagesFormType  = $imagesFormType;
    }

    /**
     * Builds form.
     * 
     * @param FormBuilderInterface $builder The builder.
     * @param array                $options The array options.
     * 
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('price', 'text')
                ->add('description', 'textarea')
                ->add('image', $this->imagesFormType ,array('data_class' => 'Entity\EcommerceBundle\Entity\Images'));
    }

    /**
     * Returns the name of the form type.
     * 
     * @return string The form's name 
     */
    public function getName()
    {
        return "products_form";
    }
}