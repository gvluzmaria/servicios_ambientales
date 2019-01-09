<?php
/**
 * Created by PhpStorm.
 * User: Informatica
 * Date: 28/10/18
 * Time: 15:33
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Usuario
 *
 * @ORM\Table(name="sa_usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario extends BaseUser{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="NoticiaAmbiental", mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $noticiaAmbiental;

    /**
     * @ORM\ManyToOne(targetEntity="TipoUsuario", inversedBy="usuario")
     * @ORM\JoinColumn(name="idTipoUsuario", referencedColumnName="id")
     */
    private $tipoUsuario;

    function __construct()
    {
        parent::__construct();
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