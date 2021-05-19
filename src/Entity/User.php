<?php

namespace App\Entity;

use App\Entity\Show;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     */
    private $passwordHash;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $streamingKey;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $profileImage;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $bio;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $streamingServer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $streamingserver;

    /**
     * @ORM\OneToMany(targetEntity=Show::class, mappedBy="user", cascade="remove")
     **/
    private $shows;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user", cascade="remove")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->shows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): self
    {

        $this->passwordHash = $passwordHash;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function checkEmailExists($email){

        return false;
    }

    public function checkNicknameExists($nickname){

        return false;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getStreamingKey(): ?string
    {
        return $this->streamingKey;
    }

    public function setStreamingKey(?string $streamingKey): self
    {
        $this->streamingKey = $streamingKey;

        return $this;
    }

    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }

    public function setProfileImage(?string $profileImage): self
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getStreamingserver(): ?string
    {
        return $this->streamingserver;
    }

    public function setStreamingserver(?string $streamingserver): self
    {
        $this->streamingserver = $streamingserver;

        return $this;
    }

    public function getShows()
    {
        return $this->shows;
    }

    public function hasShow(Show $show)
    {
        return $this->shows->contains($show);
    }

    public function addShow(Show $show)
    {
        $this->shows->add($show);
    }

    public function removeShow(Show $show)
    {
        $this->shows->removeElement($show);
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
            $order->setUserId($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUserId() === $this) {
                $order->setUserId(null);
            }
        }

        return $this;
    }

}
