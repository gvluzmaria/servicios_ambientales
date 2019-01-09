<?php
/**
 * Created by PhpStorm.
 * User: Informatica
 * Date: 28/10/18
 * Time: 13:00
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CategoriaInvestigativa
 *
 * @ORM\Table(name="sa_categoriaInvestigativa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoriaInvestigativaRepository")
 */
class CategoriaInvestigativa {

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
     * @ORM\Column(name="descripcion", type="string", length=150)
     */
    private $descripcion;

    /**
     * ORM\OnyToMany(targetEntity="CapitalHumano", mappedBy="categoriaInvestigativa", cascade={"persist", "remove"})
     */
    private $capitalHumano;

    public function __toString()
    {
        return sprintf('%s', $this->getDescripcion());
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

    /**
     * @return mixed
     */
    public function getCapitalHumano()
    {
        return $this->capitalHumano;
    }
} 