<?php

namespace App\Entity;

use App\Entity\Shows;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @Groups("order")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("order")
     * @ORM\Column(type="float", options={"default":0})
     */
    private $amount;

    /**
     * @Groups("order")
     * @ORM\Column(type="datetime", name="payment_date")
     * @SerializedName("paymentDate")
     */
    private $paymentDate;

    /**
     * @Groups("order")
     * @ORM\Column(type="string", name="payment_status", length=20)
     * @SerializedName("paymentStatus")
     */
    private $paymentStatus;

    /**
     * @Groups("order")
     * @ORM\Column(type="string", name="confirmation_code", length=50)
     * @SerializedName("confirmationCode")
     */
    private $confirmationCode;

    /**
     * @Groups("order")
     * @ORM\Column(type="text", name="payment_response")
     * @SerializedName("paymentResponse")
     */
    private $paymentResponse;

    /**
     * @Groups("order")
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @Groups("order")
     * @ORM\ManyToOne(targetEntity=Shows::class, inversedBy="orders")
     * @ORM\JoinColumn(name="shows_id", referencedColumnName="id", nullable=false)
     */
    private $shows;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(string $paymentStatus): self
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    public function getConfirmationCode(): ?string
    {
        return $this->confirmationCode;
    }

    public function setConfirmationCode(string $confirmationCode): self
    {
        $this->confirmationCode = $confirmationCode;

        return $this;
    }

    public function getPaymentResponse(): ?string
    {
        return $this->paymentResponse;
    }

    public function setPaymentResponse(string $paymentResponse): self
    {
        $this->paymentResponse = $paymentResponse;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getShows(): ?Shows
    {
        return $this->shows;
    }

    public function setShows(?Shows $shows): self
    {
        $this->shows = $shows;

        return $this;
    }
}
