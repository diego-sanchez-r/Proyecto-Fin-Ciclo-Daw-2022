<?php

namespace App\Entity;

use App\Repository\IncidenciaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IncidenciaRepository::class)]
class Incidencia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $descripcion;

    #[ORM\Column(type: 'string', length: 50)]
    private $nivel_gravedad;

    #[ORM\Column(type: 'integer')]
    private $tipo_averia;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagen;

    #[ORM\Column(type: 'string', length: 255)]
    private $latitud;

    #[ORM\Column(type: 'string', length: 255)]
    private $longitud;

    #[ORM\Column(type: 'datetime')]
    private $fecha_cracion;

    #[ORM\Column(type: 'string', length: 10)]
    private $codigo_postal;

    #[ORM\Column(type: 'integer')]
    private $id_usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getNivelGravedad(): ?string
    {
        return $this->nivel_gravedad;
    }

    public function setNivelGravedad(string $nivel_gravedad): self
    {
        $this->nivel_gravedad = $nivel_gravedad;

        return $this;
    }

    public function getTipoAveria(): ?int
    {
        return $this->tipo_averia;
    }

    public function setTipoAveria(int $tipo_averia): self
    {
        $this->tipo_averia = $tipo_averia;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getLatitud(): ?string
    {
        return $this->latitud;
    }

    public function setLatitud(string $latitud): self
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud(): ?string
    {
        return $this->longitud;
    }

    public function setLongitud(string $longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }

    public function getFechaCracion(): ?\DateTimeInterface
    {
        return $this->fecha_cracion;
    }

    public function setFechaCracion(\DateTimeInterface $fecha_cracion): self
    {
        $this->fecha_cracion = $fecha_cracion;

        return $this;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigo_postal;
    }

    public function setCodigoPostal(string $codigo_postal): self
    {
        $this->codigo_postal = $codigo_postal;

        return $this;
    }

    public function getIdUsuario(): ?int
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(int $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }
}
