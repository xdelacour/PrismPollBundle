<?php

namespace Prism\PollBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * OpinionType
 */
class OpinionType extends AbstractType
{
    /**
     * Build Form
     *
     * @param FormBuilder $builder
     * @param array       $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return 'opinion';
    }

    /**
     * Get Default Options
     *
     * @param array $options
     *
     * @return array
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Prism\PollBundle\Entity\Opinion',
        ));
    }
}