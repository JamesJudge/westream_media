<?php

namespace App\Entity;

use App\Repository\ShowsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ShowsRepository::class)
 * @ORM\Table(name="`shows`")
 */
class Shows
{
    /**
     * @Groups("shows")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("shows")
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @Groups("shows")
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @Groups("shows")
     * @ORM\Column(type="string", name="recorded_link", length=255)
     * @SerializedName("recordedLink")
     */
    private $recordedLink;

    /**
     * @Groups("shows")
     * @ORM\Column(type="float", options={"default":0})
     */
    private $amount;

    /**
     * @Groups("shows")
     * @ORM\Column(type="string", name="event_name", length=100)
     * @SerializedName("eventName")
     */
    private $eventName;

    /**
     * @Groups("shows")
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="shows")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @var  User
     */
    private $user;

    /**
     * @Groups("shows")
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="shows", cascade="remove")
     */
    private $orders;

    private $isOrdered = false;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getRecordedLink(): ?string
    {
        return $this->recordedLink;
    }

    public function setRecordedLink(string $recordedLink): self
    {
        $this->recordedLink = $recordedLink;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): self
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user = null): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setShowsId($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getShowsId() === $this) {
                $order->setShowsId(null);
            }
        }

        return $this;
    }

    public function isOrdered()
    {
        return $this->isOrdered;
    }

    public function setOrdered($isOrdered = false)
    {
        $this->isOrdered = $isOrdered;

        return $this;
    }


}
