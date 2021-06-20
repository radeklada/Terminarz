<?php
/*
 * This file is part of the Terminarz application.
 *
 * (c) Radek Łada <radlad98@gmail.com>
 *
 * For the full copyright and license information, please contact the author.
 */

namespace App\Form;

use App\Service\CategoryService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EventFormFilterType
 */
class EventFormFilterType extends AbstractType
{
    /**
     * @var \App\Service\CategoryService
     */
    private $categoryService;

    /**
     * EventFormFilterType constructor.
     * @param \App\Service\CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Builds the form.
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'category',
            ChoiceType::class,
            [
                    'choices' => $this->categoryService->getNamesForFormFilter(),
                    'label' => 'event_category',
                ]
        )
        ;
    }

    /**
     * Configures the options for this type.
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}
