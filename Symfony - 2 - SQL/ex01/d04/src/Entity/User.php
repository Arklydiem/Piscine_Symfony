<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private $username;

    #[ORM\Column(type: "string", length: 255)]
    private $name;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private $email;

    #[ORM\Column(type: "boolean")]
    private $enable;

    #[ORM\Column(type: "datetime")]
    private $birthdate;

    #[ORM\Column(type: "text")]
    private $address;
}
