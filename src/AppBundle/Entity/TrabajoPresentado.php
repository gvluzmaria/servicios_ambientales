<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28/10/2018
 * Time: 20:17
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TrabajoPresentado
 *
 * @ORM\Table(name="sa_trabajoPresentado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrabajoPresentadoRepository")
 */
class TrabajoPresentado
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="EventoExterno", inversedBy="trabajoPresentado")
     * @ORM\JoinColumn(name="idEventoExterno", referencedColumnName="id")
     */
    private $eventoExterno;

    /**
     * @ORM\ManyToOne(targetEntity="CapitalHumano", inversedBy="trabajoPresentado")
     * @ORM\JoinColumn(name="idAutor", referencedColumnName="id")
     */
    private $capitalHumano;

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
     * @param CapitalHumano $capitalHumano
     *
     * @return TrabajoPresentado
     */
    public function setCapitalHumano($capitalHumano)
    {
        $this->capitalHumano = $capitalHumano;
    }

    /**
     * @return CapitalHumano
     */
    public function getCapitalHumano()
    {
        return $this->capitalHumano;
    }

    /**
     * @param EventoExterno $eventoExterno
     *
     * @return TrabajoPresentado
     */
    public function setEventoExterno($eventoExterno)
    {
        $this->eventoExterno = $eventoExterno;
    }

    /**
     * @return EventoExterno
     */
    public function getEventoExterno()
    {
        return $this->eventoExterno;
    }
}