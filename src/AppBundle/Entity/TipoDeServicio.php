<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/10/2018
 * Time: 20:22
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TipoDeServicio
 *
 * @ORM\Table(name="sa_tipoDeServicio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoDeServicioRepository")
 */
class TipoDeServicio
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
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pagoEnEfectivo", type="boolean")
     */
    private $pagoEnEfectivo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="llevaContrato", type="boolean")
     */
    private $llevaContrato;

    /**
     * @var float
     *
     * @ORM\Column(name="precioCUP", type="float", precision=53, nullable=true)
     * @Assert\Type(type="numeric")
     */
    private $precioCUP;

    /**
     * @var float
     *
     * @ORM\Column(name="precioCUC", type="float", precision=53, nullable=true)
     * @Assert\Type(type="numeric")
     */
    private $precioCUC;

    /**
     * @var \AppBundle\Entity\TipoDeServicio
     * @ORM\ManyToOne(targetEntity="TipoDeServicio")
     * @ORM\JoinColumn(name="idSubordinadoA", referencedColumnName="id")
     */
    private $subordinadoA;

    /**
     * @var boolean
     *
     * @ORM\Column(name="seMuestraEnPagInicial", type="boolean")
     */
    private $seMuestraEnPagInicial;

    /**
     * @ORM\Column(name="imagen", type="string")
     *
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"image/gif",
     *          "image/jpeg", "image/png"
     *     }
     * )
     */
    protected $imagen;

    public function __toString()
    {
        return sprintf('%s', $this->getNombre());
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return boolean
     */
    public function isPagoEnEfectivo()
    {
        return $this->pagoEnEfectivo;
    }

    /**
     * @param boolean $pagoEnEfectivo
     */
    public function setPagoEnEfectivo($pagoEnEfectivo)
    {
        $this->pagoEnEfectivo = $pagoEnEfectivo;
    }

    /**
     * @return boolean
     */
    public function isLlevaContrato()
    {
        return $this->llevaContrato;
    }

    /**
     * @param boolean $llevaContrato
     */
    public function setLlevaContrato($llevaContrato)
    {
        $this->llevaContrato = $llevaContrato;
    }

    /**
     * @return float
     */
    public function getPrecioCUP()
    {
        return $this->precioCUP;
    }

    /**
     * @param float $precioCUP
     */
    public function setPrecioCUP($precioCUP)
    {
        $this->precioCUP = $precioCUP;
    }

    /**
     * @return float
     */
    public function getPrecioCUC()
    {
        return $this->precioCUC;
    }

    /**
     * @param float $precioCUC
     */
    public function setPrecioCUC($precioCUC)
    {
        $this->precioCUC = $precioCUC;
    }

    /**
     * @return TipoDeServicio
     */
    public function getSubordinadoA()
    {
        return $this->subordinadoA;
    }

    /**
     * @param TipoDeServicio $subordinadoA
     *
     * @return TipoDeServicio
     */
    public function setSubordinadoA($subordinadoA)
    {
        $this->subordinadoA = $subordinadoA;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isSeMuestraEnPagInicial()
    {
        return $this->seMuestraEnPagInicial;
    }

    /**
     * @param boolean $seMuestraEnPagInicial
     */
    public function setSeMuestraEnPagInicial($seMuestraEnPagInicial)
    {
        $this->seMuestraEnPagInicial = $seMuestraEnPagInicial;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
        return $this;
    }
}