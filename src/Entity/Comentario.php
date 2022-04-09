<?php

namespace App\Entity;

use App\Repository\ComentarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentarioRepository::class)]
class Comentario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $id_incidencia;

    #[ORM\Column(type: 'string', length: 255)]
    private $texto;

    #[ORM\Column(type: 'datetime')]
    private $fecha_creacion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdIncidencia(): ?int
    {
        return $this->id_incidencia;
    }

    public function setIdIncidencia(int $id_incidencia): self
    {
        $this->id_incidencia = $id_incidencia;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): self
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }
}
