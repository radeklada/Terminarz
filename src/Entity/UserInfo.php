<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserInfo
 *
 * @ORM\Table(name="user_info")
 * @ORM\Entity
 */
class UserInfo
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
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=30, nullable=false)
     */
    private $lastName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=false)
     */
    private $birthday;


}
