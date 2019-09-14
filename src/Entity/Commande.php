<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload) 
    {
        foreach ($this->getBillets() as $billet) {
            if ($billet->getFullday() && (date('G') > 14) && $this->getDate() === date("d-m-Y")) {
                $context->buildViolation('Il n\'est pas possible de reserver un billet journée après 14h pour le jour même.')
                    ->atPath('date')
                    ->addViolation();
            }
        }
        
        if (date('w', $this->getDate()->getTimestamp()) == 2) {
            $context->buildViolation('Le musée est fermé le mardi.')
                    ->atPath('date')
                    ->addViolation();
        }

        if (date('d-m', $this->getDate()->getTimestamp()) == "01-05" || date('d-m', $this->getDate()->getTimestamp()) == "01-11" || date('d-m', $this->getDate()->getTimestamp()) == "25-12") {
            $context->buildViolation('Le musée est fermé les jours fériés.')
                    ->atPath('date')
                    ->addViolation();
        }

        // $new = new \DateTime();
        // dump(date('w', $new->getTimestamp()));

        // $reponse = $this->service->getResponse($this->getDate());

        // if (($reponse > 1000) && date('w', $new->getTimestamp())) {
        //     $context->buildViolation('Le musée n\'a plus de place.')
        //             ->atPath('date')
        //             ->addViolation();
        // }
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Column(type="uuid", unique=true)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "l'email '{{ value }}' n'est pas un email valide.",
     *     checkMX = true
     * )
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="commande", cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $billets;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Callback({"App\Validator\Validator", "validateNumber"})
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    public function __construct()
    {
        $this->billets = new ArrayCollection();
        $this->uuid = Uuid::uuid4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
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

    /**
     * @return Collection|Billet[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setCommande($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): self
    {
        if ($this->billets->contains($billet)) {
            $this->billets->removeElement($billet);
            // set the owning side to null (unless already changed)
            if ($billet->getCommande() === $this) {
                $billet->setCommande(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
