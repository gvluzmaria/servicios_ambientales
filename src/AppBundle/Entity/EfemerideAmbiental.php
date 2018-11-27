<?php
/**
 * Created by PhpStorm.
 * User: Informatica
 * Date: 28/10/18
 * Time: 17:20
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * EfemerideAmbiental
 *
 * @ORM\Table(name="sa_efemerideAmbiental")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EfemerideAmbientalRepository")
 */
class EfemerideAmbiental {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var /DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="titularEfemeride", type="string", length=150)
     */
    private $titularEfemeride;

    /**
     * @var string
     *
     * @ORM\Column(name="efemeride", type="string", length=500)
     */
    private $efemeride;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoDisenno", type="string", length=150)
     */
    private $tipoDisenno;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=150)
     */
    private $foto;

    /**
     * EfemerideAmbiental constructor
     *
     * @param $id
     * @param $fecha
     * @param $titularEfemeride
     * @param $efemeride
     * @param $tipoDisenno
     * @param $foto
     */
    function __construct($id, $fecha, $titularEfemeride, $efemeride, $tipoDisenno, $foto)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->titularEfemeride = $titularEfemeride;
        $this->efemeride = $efemeride;
        $this->tipoDisenno = $tipoDisenno;
        $this->foto = $foto;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @param string $titularEfemeride
     */
    public function setTitularEfemeride($titularEfemeride)
    {
        $this->titularEfemeride = $titularEfemeride;
    }

    /**
     * @return string
     */
    public function getTitularEfemeride()
    {
        return $this->titularEfemeride;
    }

    /**
     * @param string $efemeride
     */
    public function setEfemeride($efemeride)
    {
        $this->efemeride = $efemeride;
    }

    /**
     * @return string
     */
    public function getEfemeride()
    {
        return $this->efemeride;
    }

    /**
     * @param string $tipoDisenno
     */
    public function setTipoDisenno($tipoDisenno)
    {
        $this->tipoDisenno = $tipoDisenno;
    }

    /**
     * @return string
     */
    public function getTipoDisenno()
    {
        return $this->tipoDisenno;
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
    public function getFoto()
    {
        return $this->foto;
    }

} 