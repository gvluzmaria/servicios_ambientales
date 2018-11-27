<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 24/10/2018
 * Time: 16:33
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cargo
 *
 * @ORM\Table(name="sa_cargo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CargoRepository")
 */
class Cargo
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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="CapitalHumano", mappedBy="cargo", cascade={"persist", "remove"})
     */
    private $capitalHumano;

    public function __toString()
    {
        return sprintf('%s', $this->getDescripcion());
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
}