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
}
