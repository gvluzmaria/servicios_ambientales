<?php
/**
 * Created by PhpStorm.
 * User: Informatica
 * Date: 28/10/18
 * Time: 17:42
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RedSocial
 *
 * @ORM\Table(name="sa_redSocial")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RedSocialRepository")
 */
class RedSocial {

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
     * @ORM\Column(name="redSocial", type="string", length=150)
     */
    private $redSocial;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="string", length=500)
     */
    private $info;

    /**
     * RedSocial constructor
     *
     * @param $id
     * @param $redSocial
     * @param $info
     */
    function __construct($id, $redSocial, $info)
    {
        $this->id = $id;
        $this->redSocial = $redSocial;
        $this->info = $info;
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
     * @param string $redSocial
     */
    public function setRedSocial($redSocial)
    {
        $this->redSocial = $redSocial;
    }

    /**
     * @return string
     */
    public function getRedSocial()
    {
        return $this->redSocial;
    }

    /**
     * @param string $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }
} 