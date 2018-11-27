<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/10/2018
 * Time: 20:06
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Imagen
 *
 * @ORM\Table(name="sa_imagen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImagenRepository")
 */
class Imagen
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
     * @ORM\Column(name="dirFisica", type="string", length=255)
     */
    private $dirFisica;

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
    public function getDirFisica()
    {
        return $this->dirFisica;
    }

    /**
     * @param string $dirFisica
     */
    public function setDirFisica($dirFisica)
    {
        $this->dirFisica = $dirFisica;
    }
}