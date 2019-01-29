<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 24/10/2018
 * Time: 15:56
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CapitalHumano
 *
 * @ORM\Table(name="sa_capitalHumano")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CapitalHumanoRepository")
 */
class CapitalHumano
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="resumenCurricular", type="string", length=255)
     */
    private $resumenCurricular;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=255)
     */
    private $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=30)
     */
    private $correo;

    /**
     * @var \AppBundle\Entity\Cargo
     * @ORM\ManyToOne(targetEntity="Cargo", inversedBy="capitalHumano")
     * @ORM\JoinColumn(name="idCargo", referencedColumnName="id")
     */
    private $cargo;

    /**
     * @ORM\ManyToOne(targetEntity="CategoriaDocente", inversedBy="capitalHumano")
     * @ORM\JoinColumn(name="idCategoriaDocente", referencedColumnName="id")
     */
    private $categoriaDocente;

    /**
     * @ORM\ManyToOne(targetEntity="CategoriaCientifica", inversedBy="capitalHumano")
     * @ORM\JoinColumn(name="idCategoriaCientifica", referencedColumnName="id")
     */
    private $categoriaCientifica;

    /**
     * @ORM\ManyToOne(targetEntity="CategoriaInvestigativa", inversedBy="capitalHumano")
     * @ORM\JoinColumn(name="idCategoriaInvestigativa", referencedColumnName="id")
     */
    private $categoriaInvestigativa;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="capitalHumano")
     * @ORM\JoinColumn(name="idEmpresa", referencedColumnName="id")
     */
    private $empresa;

    /**
     * @ORM\OneToMany(targetEntity="TrabajoPresentado", mappedBy="capitalHumano", cascade={"persist", "remove"})
     */
    private $trabajoPresentado;

    /**
     * @ORM\OneToMany(targetEntity="Investigacion", mappedBy="capitalHumano", cascade={"persist", "remove"})
     */
    private $investigacion;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getResumenCurricular()
    {
        return $this->resumenCurricular;
    }

    /**
     * @param string $resumenCurricular
     */
    public function setResumenCurricular($resumenCurricular)
    {
        $this->resumenCurricular = $resumenCurricular;
    }

    /**
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param string $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param string $correo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    /**
     * @return Cargo
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * @param Cargo $cargo
     *
     * @return CapitalHumano
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }

    /**
     * @return CategoriaDocente
     */
    public function getCategoriaDocente()
    {
        return $this->categoriaDocente;
    }

    /**
     * @param CategoriaDocente $categoriaDocente
     *
     * @return CapitalHumano
     */
    public function setCategoriaDocente($categoriaDocente)
    {
        $this->categoriaDocente = $categoriaDocente;
        return $this;
    }

    /**
     * @return CategoriaCientifica
     */
    public function getCategoriaCientifica()
    {
        return $this->categoriaCientifica;
    }

    /**
     * @param CategoriaCientifica $categoriaCientifica
     *
     * @return CapitalHumano
     */
    public function setCategoriaCientifica($categoriaCientifica)
    {
        $this->categoriaCientifica = $categoriaCientifica;
        return $this;
    }

    /**
     * @return CategoriaInvestigativa
     */
    public function getCategoriaInvestigativa()
    {
        return $this->categoriaInvestigativa;
    }

    /**
     * @param CategoriaInvestigativa $categoriaInvestigativa
     *
     * @return CapitalHumano
     */
    public function setCategoriaInvestigativa($categoriaInvestigativa)
    {
        $this->categoriaInvestigativa = $categoriaInvestigativa;
        return $this;
    }

    /**
     * @return Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param Empresa $empresa
     *
     * @return CapitalHumano
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }

    public function __toString()
    {
        return sprintf('%s', $this->getNombre());
    }

    /**
     * @param mixed $investigacion
     */
    public function setInvestigacion($investigacion)
    {
        $this->investigacion = $investigacion;
    }

    /**
     * @return mixed
     */
    public function getInvestigacion()
    {
        return $this->investigacion;
    }

    /**
     * @param mixed $trabajoPresentado
     */
    public function setTrabajoPresentado($trabajoPresentado)
    {
        $this->trabajoPresentado = $trabajoPresentado;
    }

    /**
     * @return mixed
     */
    public function getTrabajoPresentado()
    {
        return $this->trabajoPresentado;
    }
}