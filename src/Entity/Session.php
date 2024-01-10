<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\Column(type: Types::BINARY)]
    private $closed = null;

    #[ORM\Column]
    private ?int $nb_slot = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formation $Formation = null;

    #[ORM\OneToMany(mappedBy: 'Session', targetEntity: Programme::class)]
    private Collection $programmes;

    #[ORM\OneToMany(mappedBy: 'Session', targetEntity: RegisterSession::class)]
    private Collection $students;

    public function __construct()
    {
        $this->programmes = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getClosed()
    {
        return $this->closed;
    }

    public function setClosed($closed): static
    {
        $this->closed = $closed;

        return $this;
    }

    public function getNbSlot(): ?int
    {
        return $this->nb_slot;
    }

    public function setNbSlot(int $nb_slot): static
    {
        $this->nb_slot = $nb_slot;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->Formation;
    }

    public function setFormation(?Formation $Formation): static
    {
        $this->Formation = $Formation;

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes->add($programme);
            $programme->setSession($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getSession() === $this) {
                $programme->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RegisterSession>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(RegisterSession $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setSession($this);
        }

        return $this;
    }

    public function removeStudent(RegisterSession $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getSession() === $this) {
                $student->setSession(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->title;
    }

    public function showDates() {
        return $this->dateStart->format('d/m/Y').' > '.$this->dateEnd->format('d/m/Y');
    }

    public function slotTaken() {
        $students = count($this->students);

        return $students;
    }
    public function slotFree() {
        $nb_slot = $this->nb_slot;
        $students = count($this->students);

        $slotFree = $nb_slot - $students;

        return $slotFree;
    }

   
}
