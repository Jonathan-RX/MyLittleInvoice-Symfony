<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DataTransformer\InvoiceToNumberTransformer;

class PaymentType extends AbstractType
{
    private $transformer;

    public function __construct(InvoiceToNumberTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('invoice', TextType::class, [
                'label' => 'Invoice Number',
                'invalid_message' => 'That is not a valid invoice number'
            ])
            ->add('amount')
            ->add('date', DateType::class,[
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('mode', ChoiceType::class, [
                'choices' => [
                    'Money' => '0',
                    'Check' => '1',
                    'Bank transfer' => '2',
                    'Bank card' => '3',
                    'Paypal' => '4',
                    'Other' => '5'
                ]
            ])
        ;
        $builder->get('invoice')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
            'allow_extra_fields' => true,
        ]);
    }
}
