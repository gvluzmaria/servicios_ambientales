<?php
/**
 * Created by PhpStorm.
 * User: Informatica
 * Date: 28/10/18
 * Time: 13:51
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * NoticiaAmbiental
 *
 * @ORM\Table(name="sa_noticiaAmbiental")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NoticiaAmbientalRepository")
 */
class NoticiaAmbiental {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaPublicacion", type="datetime")
     */
    private $fechaPublicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="titular", type="string", length=250)
     */
    private $titular;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=500)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="noticiaAmbiental")
     * @ORM\JoinColumn(name="idAutor", referencedColumnName="id")
     */
    private $usuario;

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
     * @return \DateTime
     */
    public function getFechaPublicacion()
    {
        return $this->fechaPublicacion;
    }

    /**
     * @param \DateTime $fechaPublicacion
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fechaPublicacion = $fechaPublicacion;
    }

    /**
     * @param string $titular
     */
    public function setTitular($titular)
    {
        $this->titular = $titular;
    }

    /**
     * @return string
     */
    public function getTitular()
    {
        return $this->titular;
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

} 