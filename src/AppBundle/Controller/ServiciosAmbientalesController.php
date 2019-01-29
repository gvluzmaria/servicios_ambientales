<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServiciosAmbientalesController extends Controller
{
    /**
     * @Route("/admin", name="admin_list")
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('ambientales/index.html.twig');
    }

    /**
     * Para los datos en la pantalla principal
     *
     * @Route("/", name="empresa_info")
     */
    public function infoAction(Request $request)
    {
        $empresa = $this->getDoctrine()
            ->getRepository('AppBundle:Empresa')
            ->findTop1();
        $tiposDeServicio = $this->getDoctrine()
            ->getRepository('AppBundle:TipoDeServicio')
            ->findTop6TiposServicio();
        $eventosCSA = $this->getDoctrine()
            ->getRepository('AppBundle:EventoCSA')
            ->findTop4EventosCSA();
        return $this->render('entidades/main.html.twig', array(
            'empresas' => $empresa,
            'tiposDeServicio' => $tiposDeServicio,
            'eventosCSA' => $eventosCSA
        ));
    }

    /**
     * Para los listados
     * @Route("/listados", name="elements_list")
     */
    public function listadosAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('ambientales/listados.html.twig');
    }

    /**
     * Para los detalles de los listados
     * @Route("/detalles", name="list_details")
     */
    public function detallesListadosAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('ambientales/detalles.html.twig');
    }
}
