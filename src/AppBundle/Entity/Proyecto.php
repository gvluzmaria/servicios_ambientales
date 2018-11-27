<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/10/2018
 * Time: 20:15
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Proyecto
 *
 * @ORM\Table(name="sa_proyecto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProyectoRepository")
 */
class Proyecto
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
}