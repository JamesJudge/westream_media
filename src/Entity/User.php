<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, unique=true)
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $password;

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
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank
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
     * @ORM\OneToMany(targetEntity=Shows::class, mappedBy="user", cascade="remove")
     **/
    private $shows;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user", cascade="remove")
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity=UserType::class, inversedBy="user")
     * @ORM\JoinColumn(name="user_type_id", referencedColumnName="id")
     */
    private $userType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @SerializedName("isAdmin")
     */
    private $isAdmin;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getStreamingServer(): ?string
    {
        return $this->streamingServer;
    }

    public function setStreamingServer(?string $streamingServer): self
    {
        $this->streamingServer = $streamingServer;

        return $this;
    }

    public function getUserType()
    {
        return $this->userType;
    }

    public function addUserType(UserType $userType)
    {
        $this->userType = $userType;

        return $this;
    }

    public function getShows()
    {
        return $this->shows;
    }

    public function hasShows(Shows $shows)
    {
        return $this->shows->contains($shows);
    }

    public function addShows(Shows $shows)
    {
        $this->shows->add($shows);
    }

    public function removeShows(Shows $shows)
    {
        $this->shows->removeElement($shows);
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

    public function isAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(?bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }
}
