<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "bank_accounts")]
class BankAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    private $iban;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    private $bank_name;

    // Getter for id
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getters and setters for other properties
    public function getIban(): ?string
    {
        return $this->iban;
    }

    public  function setIban(string $iban): self
    {
        $this->iban = $iban;
        return $this;
    }

    public function getBankName(): ?string
    {
        return $this->bank_name;
    }

    public  function setBankName(string $bank_name): self
    {
        $this->bank_name = $bank_name;
        return $this;
    }

}
