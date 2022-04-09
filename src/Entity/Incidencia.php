<?php

namespace App\Entity;

use App\Repository\IncidenciaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(targetEntity: Usuario::class, inversedBy: 'incidencia')]
    #[ORM\JoinColumn(nullable: false)]
    private $usuario;

    #[ORM\OneToMany(mappedBy: 'incidencia', targetEntity: Comentario::class)]
    private $comentarios;

    #[ORM\OneToOne(targetEntity: TipoAveria::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $averia;

    public function __construct()
    {
        $this->comentarios = new ArrayCollection();
    }

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

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return Collection<int, Comentario>
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): self
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios[] = $comentario;
            $comentario->setIncidencia($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): self
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getIncidencia() === $this) {
                $comentario->setIncidencia(null);
            }
        }

        return $this;
    }

    public function getAveria(): ?TipoAveria
    {
        return $this->averia;
    }

    public function setAveria(TipoAveria $averia): self
    {
        $this->averia = $averia;

        return $this;
    }
}
