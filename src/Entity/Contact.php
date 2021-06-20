<?php
/*
 * This file is part of the Terminarz application.
 *
 * (c) Radek Łada <radlad98@gmail.com>
 *
 * For the full copyright and license information, please contact the author.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 * @ORM\Table(name="contacts", uniqueConstraints={@ORM\UniqueConstraint(name="phone_number_UNIQUE", columns={"phone_number"})})
 * @ORM\Entity
 */
class Contact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=30, nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $firstName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=30, nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $lastName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=20, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^(\([0-9]+\))?([+0-9 -]+)$/")
     */
    private $phoneNumber = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = (string) $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = (string) $lastName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = (string) $phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
