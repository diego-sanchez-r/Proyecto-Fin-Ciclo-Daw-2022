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

    #[ORM\Column(type: 'string', length: 255)]
    private $texto;

    #[ORM\Column(type: 'datetime')]
    private $fechaCreacion;

    #[ORM\ManyToOne(targetEntity: Incidencia::class, inversedBy: 'comentarios')]
    private $incidencia;
    
    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: 'comentarios')]
    private $usuario;
    
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

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion($fechaCreacion): void {
        $this->fechaCreacion = $fechaCreacion;
    }

    
    public function getIncidencia(): ?incidencia
    {
        return $this->incidencia;
    }

    public function setIncidencia(?incidencia $incidencia): self
    {
        $this->incidencia = $incidencia;

        return $this;
    }
    
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario): void {
        $this->usuario = $usuario;
    }


}
