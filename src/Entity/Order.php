<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order implements SerializableEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=OrderType::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=OrderStage::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?OrderType
    {
        return $this->type;
    }

    public function setType(?OrderType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getStage(): ?OrderStage
    {
        return $this->stage;
    }

    public function setStage(?OrderStage $stage): self
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType()->getName(),
            'stage' => $this->getStage()->getName(),
            'client_id' => $this->getClient()->getId(),
        ];
    }

}
