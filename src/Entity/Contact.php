<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;
use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'The field can\'t be empty')]
    #[Assert\Length(min: 3, max: 10, minMessage: 'at least {{ limit }} characters', maxMessage: 'no more than {{ limit }} characters')]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'The field can\'t be empty')]
    #[Assert\Length(min: 5, max: 30, minMessage: 'at least {{ limit }} characters', maxMessage: 'no more than {{ limit }} characters')]
    #[Assert\Email(message: 'The email {{ value }} is not a valid email.')]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'The field can\'t be empty')]
    #[Assert\Length(min: 3, max: 30, minMessage: 'at least {{ limit }} characters', maxMessage: 'no more than {{ limit }} characters')]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'The field can\'t be empty')]
    #[Assert\Length(min: 3, max: 200, minMessage: 'at least {{ limit }} characters', maxMessage: 'no more than {{ limit }} characters')]
    private ?string $message = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

}
