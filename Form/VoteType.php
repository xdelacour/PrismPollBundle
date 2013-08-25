<?php

namespace Prism\PollBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

/**
 * VoteType
 */
class VoteType extends AbstractType
{

    protected $options;

    /**
     * Build Form
     *
     * @param FormBuilder $builder
     * @param array       $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        var_dump($options);die;

        $this->options = $options;

        $builder
            ->add('opinions', 'choice', array(
                'multiple' => false,
                'expanded' => true,
                'choices' => $options['opinionsChoices']
            ));
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return "vote";
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
        if (!isset($this->options['opinionsChoices'])) {
            throw new MissingOptionsException("You must provide the \"opinionsChoices\" option.", $this->options);
        }

        $collectionConstraint = new Collection(array(
            'opinions' => array(
                new NotNull(array('message' => "Please select a choice.")),
                new Choice(array('choices' => array_keys($this->options['opinionsChoices'])))
            )
        ));

        $resolver->setDefaults(array(
            'opinionsChoices' => $this->options['opinionsChoices'],
            'validation_constraint' => $collectionConstraint
        ));
    }
}