<?php

namespace App\Entity;

use App\Repository\CustomersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomersRepository::class)]
class Customers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $code = null;

    #[ORM\Column]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $address = null;

    #[ORM\Column]
    private ?string $pc = null;

    #[ORM\Column]
    private ?string $city = null;

    #[ORM\Column]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $phone = null;

    #[ORM\Column]
    private ?bool $pro = null;

    #[ORM\Column(nullable: true)]
    private ?string $siret = null;

    #[ORM\Column]
    private ?string $rib = null;

    #[ORM\Column(nullable: true)]
    private ?string $bic = null;

    #[ORM\Column]
    private ?string $website = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getPc(): ?string
    {
        return $this->pc;
    }

    public function setPc(?string $pc): void
    {
        $this->pc = $pc;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPro(): ?bool
    {
        return $this->pro;
    }

    public function setPro(?bool $pro): void
    {
        $this->pro = $pro;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): void
    {
        $this->siret = $siret;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(?string $rib): void
    {
        $this->rib = $rib;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(?string $bic): void
    {
        $this->bic = $bic;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

}
