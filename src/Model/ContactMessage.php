<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ContactMessage
{
    #[Assert\NotBlank(message: 'Le titre de la demande est requis.')]
    private ?string $titreDemande = null;

    #[Assert\NotBlank(message: 'Le message ne peut pas être vide.')]
    private ?string $message = null;

    #[Assert\NotBlank(message: 'L\'email est requis.')]
    #[Assert\Email(message: 'Veuillez entrer une adresse email valide.')]
    private ?string $email = null;

    // Getters et setters

    public function getTitreDemande(): ?string
    {
        return $this->titreDemande;
    }

    public function setTitreDemande(string $titreDemande): self
    {
        $this->titreDemande = $titreDemande;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
