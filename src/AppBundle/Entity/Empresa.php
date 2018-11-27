<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/10/2018
 * Time: 19:50
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Empresa
 *
 * @ORM\Table(name="sa_empresa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmpresaRepository")
 */
class Empresa
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
     * @ORM\Column(name="nombreEmpresa", type="string", length=100)
     */
    private $nombreEmpresa;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=30)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=100)
     */
    private $telefonos;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="infoGeneral", type="string", length=255)
     */
    private $infoGeneral;

    /**
     * @var string
     *
     * @ORM\Column(name="objetoSocial", type="string", length=255)
     */
    private $objetoSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="estructuraCentro", type="string", length=255)
     */
    private $estructuraCentro;

    /**
     * @ORM\OneToMany(targetEntity="CapitalHumano", mappedBy="empresa", cascade={"persist", "remove"})
     */
    private $capitalHumano;

    /**
     * @ORM\OneToMany(targetEntity="Publicacion", mappedBy="empresa", cascade={"persist", "remove"})
     */
    private $publicacion;

    public function __toString()
    {
        return sprintf('%s', $this->getNombreEmpresa());
    }

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
    public function getNombreEmpresa()
    {
        return $this->nombreEmpresa;
    }

    /**
     * @param string $nombreEmpresa
     */
    public function setNombreEmpresa($nombreEmpresa)
    {
        $this->nombreEmpresa = $nombreEmpresa;
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
     * @return string
     */
    public function getTelefonos()
    {
        return $this->telefonos;
    }

    /**
     * @param string $telefonos
     */
    public function setTelefonos($telefonos)
    {
        $this->telefonos = $telefonos;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getInfoGeneral()
    {
        return $this->infoGeneral;
    }

    /**
     * @param string $infoGeneral
     */
    public function setInfoGeneral($infoGeneral)
    {
        $this->infoGeneral = $infoGeneral;
    }

    /**
     * @return string
     */
    public function getObjetoSocial()
    {
        return $this->objetoSocial;
    }

    /**
     * @param string $objetoSocial
     */
    public function setObjetoSocial($objetoSocial)
    {
        $this->objetoSocial = $objetoSocial;
    }

    /**
     * @return string
     */
    public function getEstructuraCentro()
    {
        return $this->estructuraCentro;
    }

    /**
     * @param string $estructuraCentro
     */
    public function setEstructuraCentro($estructuraCentro)
    {
        $this->estructuraCentro = $estructuraCentro;
    }

    /**
     * @return mixed
     */
    public function getCapitalHumano()
    {
        return $this->capitalHumano;
    }

    /**
     * @param mixed $capitalHumano
     */
    public function setCapitalHumano($capitalHumano)
    {
        $this->capitalHumano = $capitalHumano;
    }

    /**
     * @return mixed
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }

    /**
     * @param mixed $publicacion
     */
    public function setPublicacion($publicacion)
    {
        $this->publicacion = $publicacion;
    }

}