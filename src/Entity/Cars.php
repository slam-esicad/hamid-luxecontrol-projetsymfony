<?php

namespace App\Entity;

use App\Repository\CarsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CarsRepository::class)]
class Cars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['cars.index'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['cars.index'])]
    private ?string $model = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['cars.index'])]
    private ?string $img = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['cars.index'])]
    private ?int $km = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['cars.index'])]
    private ?string $reg_number = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['cars.index'])]
    private ?string $comment = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['cars.index'])]
    private ?string $energy = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['cars.index'])]
    private ?int $tank = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['cars.index'])]
    private ?int $horsepower = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['cars.index'])]
    private ?string $gearbox = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['cars.index'])]
    private ?int $doors = null;

    #[ORM\Column]
    #[Groups(['cars.index'])]
    private ?int $dayprice = null;

    #[ORM\Column]
    #[Groups(['cars.index'])]
    private ?int $buyprice = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['cars.index'])]
    private ?int $year = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['cars.index'])]
    private ?string $color = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[Groups(['cars.index'])]
    private ?Brands $brand = null;

    #[ORM\OneToMany(targetEntity: Contracts::class, mappedBy: 'car')]
    private Collection $contracts;

    #[ORM\Column]
    #[Groups(['cars.index'])]
    private ?bool $selled = null;

    #[ORM\OneToMany(targetEntity: Maintenances::class, mappedBy: 'car')]
    private Collection $maintenances;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->maintenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): static
    {
        $this->km = $km;

        return $this;
    }

    public function getRegNumber(): ?string
    {
        return $this->reg_number;
    }

    public function setRegNumber(string $reg_number): static
    {
        $this->reg_number = $reg_number;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getEnergy(): ?string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getTank(): ?int
    {
        return $this->tank;
    }

    public function setTank(int $tank): static
    {
        $this->tank = $tank;

        return $this;
    }

    public function getHorsepower(): ?int
    {
        return $this->horsepower;
    }

    public function setHorsepower(int $horsepower): static
    {
        $this->horsepower = $horsepower;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): static
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getDoors(): ?int
    {
        return $this->doors;
    }

    public function setDoors(int $doors): static
    {
        $this->doors = $doors;

        return $this;
    }

    public function getDayprice(): ?int
    {
        return $this->dayprice;
    }

    public function setDayprice(int $dayprice): static
    {
        $this->dayprice = $dayprice;

        return $this;
    }

    public function getBuyprice(): ?int
    {
        return $this->buyprice;
    }

    public function setBuyprice(int $buyprice): static
    {
        $this->buyprice = $buyprice;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getBrand(): ?Brands
    {
        return $this->brand;
    }

    public function setBrand(?Brands $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, Contracts>
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contracts $contract): static
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts->add($contract);
            $contract->setCar($this);
        }

        return $this;
    }

    public function removeContract(Contracts $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getCar() === $this) {
                $contract->setCar(null);
            }
        }

        return $this;
    }

    public function isSelled(): ?bool
    {
        return $this->selled;
    }

    public function setSelled(bool $selled): static
    {
        $this->selled = $selled;

        return $this;
    }

    /**
     * @return Collection<int, Maintenances>
     */
    public function getMaintenances(): Collection
    {
        return $this->maintenances;
    }

    public function addMaintenance(Maintenances $maintenance): static
    {
        if (!$this->maintenances->contains($maintenance)) {
            $this->maintenances->add($maintenance);
            $maintenance->setCar($this);
        }

        return $this;
    }

    public function removeMaintenance(Maintenances $maintenance): static
    {
        if ($this->maintenances->removeElement($maintenance)) {
            // set the owning side to null (unless already changed)
            if ($maintenance->getCar() === $this) {
                $maintenance->setCar(null);
            }
        }

        return $this;
    }
}
