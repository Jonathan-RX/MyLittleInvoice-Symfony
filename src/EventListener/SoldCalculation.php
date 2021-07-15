<?php

namespace App\EventListener;

use App\Entity\Invoice;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SoldCalculation
{
    public function prePersist(Invoice $invoice, LifecycleEventArgs $args): void
    {
        $sold = 0;
        foreach ($invoice->getContent() as $content){
            $sold += $content['price'] * ($content['taxes']/100+1) * $content['quantity'];
        }
        $invoice->setSold($sold);
    }
    public function preUpdate(Invoice $invoice, LifecycleEventArgs $args): void
    {
        $sold = 0;
        foreach ($invoice->getContent() as $content){
            $sold += $content['price'] * ($content['taxes']/100+1) * $content['quantity'];
        }
        foreach ($invoice->getPayments() as $payment){
            $sold -= $payment->getAmount();
        }
        $invoice->setSold($sold);
    }
}