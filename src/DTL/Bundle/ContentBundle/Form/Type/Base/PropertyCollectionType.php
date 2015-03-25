<?php

namespace DTL\Bundle\ContentBundle\Form\Type\Base;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use DTL\Component\Content\Property\PropertyTypeInterface;
use DTL\Component\Content\FrontView\FrontView;
use DTL\Bundle\ContentBundle\Form\EventListener\ResizeableListener;
use DTL\Bundle\ContentBundle\Form\DataTransformer\MultipleToSingleTransformer;

/**
 * This type wraps the other content types and makes them resizable.
 *
 * All content properties in Sulu are capable of being "multiple". i.e.
 * when max_occurs > 1.
 *
 * This means that we must wrap all of the form types in a resizeable form
 * type, which knows when a property is multiple and is then capable
 * of mapping the additional incoming data.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PropertyCollectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'min_occurs' => 1,
            'max_occurs' => 1,
            'multiple' => function (Options $options) {
                return $options['min_occurs'] !== $options['max_occurs'];
            },
            'compound' => true,
            'options' => array(),
            'allow_add' => true,
            'allow_delete' => true,
        ));

        $resolver->setRequired(array(
            'type',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'property_collection';
    }

    public function getParent()
    {
        return 'collection';
    }
}