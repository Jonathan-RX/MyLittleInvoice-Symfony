<?php

namespace App\Entity;

use App\Repository\QuotationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuotationRepository::class)
 */
class Quotation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="quotations")
     */
    private $Customer;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $adress = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $content = [];

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $printed;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $send_by_mail;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="quotations")
     */
    private $created_by;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    public function setCustomer(?Customer $Customer): self
    {
        $this->Customer = $Customer;

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

    public function getContent(): ?array
    {
        return $this->content;
    }

    public function setContent(?array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPrinted(): ?bool
    {
        return $this->printed;
    }

    public function setPrinted(?bool $printed): self
    {
        $this->printed = $printed;

        return $this;
    }

    public function getSendByMail(): ?bool
    {
        return $this->send_by_mail;
    }

    public function setSendByMail(?bool $send_by_mail): self
    {
        $this->send_by_mail = $send_by_mail;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }
}
