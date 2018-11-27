<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/10/2018
 * Time: 20:34
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * EventoCSA
 *
 * @ORM\Table(name="sa_eventoCSA")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventoCSARepository")
 */
class EventoCSA
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicial", type="date")
     */
    private $fechaInicial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFinal", type="date")
     */
    private $fechaFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="contactos", type="string", length=100)
     */
    private $contactos;

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
     * @return \DateTime
     */
    public function getFechaInicial()
    {
        return $this->fechaInicial;
    }

    /**
     * @param \DateTime $fechaInicial
     */
    public function setFechaInicial($fechaInicial)
    {
        $this->fechaInicial = $fechaInicial;
    }

    /**
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * @param \DateTime $fechaFinal
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;
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
     * @return string
     */
    public function getContactos()
    {
        return $this->contactos;
    }

    /**
     * @param string $contactos
     */
    public function setContactos($contactos)
    {
        $this->contactos = $contactos;
    }
}