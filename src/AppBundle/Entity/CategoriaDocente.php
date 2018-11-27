<?php
/**
 * Created by PhpStorm.
 * User: seginf
 * Date: 25/10/18
 * Time: 14:17
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CategoriaDocente
 *
 * @ORM\Table(name="sa_categoriaDocente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriaDocenteRepository")
 */
class CategoriaDocente {
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
     * @ORM\Column(name="descripcion", type="string", length=100)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="CapitalHumano", mappedBy="categoriaDocente", cascade={"persist", "remove"})
     */
    private $capitalHumano;

    public function __toString()
    {
        return sprintf('%s', $this->getDescripcion());
    }

    /**
     * @return mixed
     */
    public function getCapitalHumano()
    {
        return $this->capitalHumano;
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
     * @param mixed $capitalHumano
     */
    public function setCapitalHumano($capitalHumano)
    {
        $this->capitalHumano = $capitalHumano;
    }
} 