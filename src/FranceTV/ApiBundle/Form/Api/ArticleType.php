<?php
/**
 * Created by PhpStorm.
 * User: SOunalli
 * Date: 04/11/2016
 * Time: 11:51
 */

namespace FranceTV\ApiBundle\Form\Api;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{

    /**
     * Form builder.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'description' => 'Title.',
                    'required' => true,
                ]
            )
            ->add(
                'leading',
                TextareaType::class,
                [
                    'description' => 'Leading text.',
                    'required' => false,
                ]
            )
            ->add(
                'body',
                TextareaType::class,
                [
                    'description' => 'Body text.',
                    'required' => true,
                ]
            )
            ->add(
                'createdBy',
                TextType::class,
                [
                    'description' => 'Title.',
                    'required' => true,
                ]
            )
        ;
    }

    /**
     * Form default values.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'FranceTV\ApiBundle\Entity\Article',
                'allow_extra_fields' => true,
                'csrf_protection' => false,
            ]
        );
    }

    /**
     * Form name.
     *
     * @return string
     */
    public function getName()
    {
        return '';
    }
}