<?php

namespace App\EventListener;

use App\Entity\Invoice;
use App\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SoldCalculation
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function prePersist(Invoice $invoice, LifecycleEventArgs $args): void
    {
        $sold = $this->SoldUpdate($invoice);
        $invoice->setSold($sold);
    }
    public function preUpdate(Invoice $invoice, LifecycleEventArgs $args): void
    {
        $sold = $this->SoldUpdate($invoice);
        $invoice->setSold($sold);
    }
    public function postPersist(Payment $payment, LifecycleEventArgs $args): void
    {
        $invoice = $payment->getInvoice();
        $sold = $this->SoldUpdate($invoice);
        $invoice->setSold($sold);
        $payment->setCustomer($invoice->getCustomer());
        $this->entityManager->persist($payment);
        $this->entityManager->persist($invoice);
        $this->entityManager->flush();
    }

    private function SoldUpdate(Invoice $invoice){
        $sold = 0;
        foreach ($invoice->getContent() as $content){
            $sold += $content['price'] * ($content['taxes']/100+1) * $content['quantity'];
        }
        foreach ($invoice->getPayments() as $payment){
            $sold -= $payment->getAmount();
        }
        return $sold;
    }
}