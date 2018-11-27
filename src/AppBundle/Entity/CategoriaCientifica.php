<?php
/**
 * Created by PhpStorm.
 * User: Informatica
 * Date: 28/10/18
 * Time: 12:24
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CategoriaCientifica
 *
 * @ORM\Table(name="sa_categoriaCientifica")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriaCientificaRepository")
 */
class CategoriaCientifica {

    /**
     * @var int
     *
     * @ORM\Column(name = "id", type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=150)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="CapitalHumano", mappedBy="categoriaCientifica", cascade={"persist", "remove"})
     */
    private $capitalHumano;

    public function __toString()
    {
        return sprintf('%s', $this->getDescripcion());
    }

    /**
     * CategoriaCientifica constructor.
     * @param int $id
     * @param string $descripcion
     */
    function __construct($id, $descripcion)
    {
        $this->descripcion = $descripcion;
        $this->id = $id;
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
    public function getCapitalHumano()
    {
        return $this->capitalHumano;
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

} 