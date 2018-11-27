<?php
/**
 * Created by PhpStorm.
 * User: Informatica
 * Date: 28/10/18
 * Time: 17:01
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TipoUsuario
 *
 * @ORM\Table(name="sa_tipoUsuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TipoUsuarioRepository")
 */
class TipoUsuario {

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
     * @ORM\Column(name="tipoUsuario", type="string", length=150)
     */
    private $tipoUsuario;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="tipoUsuario", cascade={"persist", "remove"})
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
     * @param string $tipoUsuario
     */
    public function setTipoUsuario($tipoUsuario)
    {
        $this->tipoUsuario = $tipoUsuario;
    }

    /**
     * @return string
     */
    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
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