<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 25/10/2018
 * Time: 19:51
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Investigacion
 *
 * @ORM\Table(name="sa_investigacion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvestigacionRepository")
 */
class Investigacion
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
     * @ORM\Column(name="nombreInvestigacion", type="string", length=255)
     */
    private $nombreInvestigacion;

    /**
     * @var string
     *
     * @ORM\Column(name="resultados", type="string", length=255)
     */
    private $resultados;

    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="investigacion")
     * @ORM\JoinColumn(name="idEmpresa", referencedColumnName="id")
     */
    private $empresa;

    /**
     * @ORM\ManyToOne(targetEntity="CapitalHumano", inversedBy="investigacion")
     * @ORM\JoinColumn(name="idAutor", referencedColumnName="id")
     */
    private $capitalHumano;

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
    public function getNombreInvestigacion()
    {
        return $this->nombreInvestigacion;
    }

    /**
     * @param string $nombreInvestigacion
     */
    public function setNombreInvestigacion($nombreInvestigacion)
    {
        $this->nombreInvestigacion = $nombreInvestigacion;
    }

    /**
     * @return string
     */
    public function getResultados()
    {
        return $this->resultados;
    }

    /**
     * @param string $resultados
     */
    public function setResultados($resultados)
    {
        $this->resultados = $resultados;
    }

    /**
     * @param CapitalHumano $capitalHumano
     *
     * @return Investigacion
     */
    public function setCapitalHumano($capitalHumano)
    {
        $this->capitalHumano = $capitalHumano;
    }

    /**
     * @return CapitalHumano
     */
    public function getCapitalHumano()
    {
        return $this->capitalHumano;
    }

    /**
     * @param Empresa $empresa
     *
     * @return Investigacion
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }

    /**
     * @return Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}