<?php

namespace App\Form\DataTransformer;

use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class InvoiceToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Invoice|null $invoice
     */
    public function transform($invoice)
    {
        if($invoice === null){
            return '';
        }
        return $invoice->getId();
    }

    public function reverseTransform($invoiceId): ?Invoice
    {
        if(!$invoiceId){
            return null;
        }

        $invoice = $this->entityManager
            ->getRepository(Invoice::class)
            ->find($invoiceId);

        if($invoice === null){
            throw new TransformationFailedException('This invoice number does not exist');
        }

        return $invoice;
    }
}