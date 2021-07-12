<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $adress = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Quotation::class, mappedBy="Customer")
     */
    private $quotations;

    /**
     * @ORM\OneToMany(targetEntity=Invoice::class, mappedBy="Customer")
     */
    private $invoices;

    /**
     * @ORM\OneToMany(targetEntity=Payment::class, mappedBy="Customer")
     */
    private $payments;

    public function __construct()
    {
        $this->quotations = new ArrayCollection();
        $this->invoices = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdress(): ?array
    {
        return $this->adress;
    }

    public function setAdress(?array $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Quotation[]
     */
    public function getQuotations(): Collection
    {
        return $this->quotations;
    }

    public function addQuotation(Quotation $quotation): self
    {
        if (!$this->quotations->contains($quotation)) {
            $this->quotations[] = $quotation;
            $quotation->setCustomer($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): self
    {
        if ($this->quotations->removeElement($quotation)) {
            // set the owning side to null (unless already changed)
            if ($quotation->getCustomer() === $this) {
                $quotation->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invoice[]
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): self
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices[] = $invoice;
            $invoice->setCustomer($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): self
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCustomer() === $this) {
                $invoice->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setCustomer($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getCustomer() === $this) {
                $payment->setCustomer(null);
            }
        }

        return $this;
    }
}
