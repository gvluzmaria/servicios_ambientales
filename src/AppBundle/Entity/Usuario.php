<?php
/**
 * Created by PhpStorm.
 * User: Informatica
 * Date: 28/10/18
 * Time: 15:33
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Usuario
 *
 * @ORM\Table(name="sa_usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario {

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
     * @ORM\Column(name="nombreUsuario", type="string", length=150)
     */
    private $nombreUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="contrasenna", type="string", length=150)
     */
    private $contrasenna;

    /**
     * @ORM\OneToMany(targetEntity="NoticiaAmbiental", mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $noticiaAmbiental;

    /**
     * @ORM\ManyToOne(targetEntity="TipoUsuario", inversedBy="usuario")
     * @ORM\JoinColumn(name="idTipoUsuario", referencedColumnName="id")
     */
    private $tipoUsuario;

    /**
     * Usuario constructor
     *
     * @param $id
     * @param $nombreUsuario
     * @param $contrasenna
     */
    function __construct($id, $nombreUsuario, $contrasenna)
    {
        $this->id = $id;
        $this->nombreUsuario = $nombreUsuario;
        $this->contrasenna = $contrasenna;
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
     * @param string $nombreUsuario
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    /**
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * @param string $contrasenna
     */
    public function setContrasenna($contrasenna)
    {
        $this->contrasenna = $contrasenna;
    }

    /**
     * @return string
     */
    public function getContrasenna()
    {
        return $this->contrasenna;
    }

    /**
     * @return mixed
     */
    public function getNoticiaAmbiental()
    {
        return $this->noticiaAmbiental;
    }

    /**
     * @param mixed $noticiaAmbiental
     */
    public function setNoticiaAmbiental($noticiaAmbiental)
    {
        $this->noticiaAmbiental = $noticiaAmbiental;
    }

    /**
     * @param mixed $tipoUsuario
     */
    public function setTipoUsuario($tipoUsuario)
    {
        $this->tipoUsuario = $tipoUsuario;
    }

    /**
     * @return mixed
     */
    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
    }
}