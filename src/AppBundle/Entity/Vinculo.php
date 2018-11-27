<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/10/2018
 * Time: 20:12
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Vinculo
 *
 * @ORM\Table(name="sa_vinculo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VinculoRepository")
 */
class Vinculo
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
     * @ORM\Column(name="vinculo", type="string", length=30)
     */
    private $vinculo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

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
    public function getVinculo()
    {
        return $this->vinculo;
    }

    /**
     * @param string $vinculo
     */
    public function setVinculo($vinculo)
    {
        $this->vinculo = $vinculo;
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
}