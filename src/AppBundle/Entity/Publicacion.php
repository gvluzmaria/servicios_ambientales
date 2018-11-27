<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/10/2018
 * Time: 19:50
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Publicacion
 *
 * @ORM\Table(name="sa_publicacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PublicacionRepository")
 */
class Publicacion
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
     * @ORM\Column(name="nombrePublicacion", type="string", length=255)
     */
    private $nombrePublicacion;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="publicacion")
     * @ORM\JoinColumn(name="idEmpresa", referencedColumnName="id")
     */
    private $empresa;

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
    public function getNombrePublicacion()
    {
        return $this->nombrePublicacion;
    }

    /**
     * @param string $nombrePublicacion
     */
    public function setNombrePublicacion($nombrePublicacion)
    {
        $this->nombrePublicacion = $nombrePublicacion;
    }

    /**
     * @return mixed
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param mixed $empresa
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }
}