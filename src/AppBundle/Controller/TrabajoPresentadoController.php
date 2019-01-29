<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19/11/2018
 * Time: 21:04
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CapitalHumano;
use AppBundle\Entity\TrabajoPresentado;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\ChoiceList\View\ChoiceListView;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TrabajoPresentadoController extends Controller
{
    /**
     * Lists all TrabajoPresentado entities.
     *
     * @Route("/trabajo_presentado", name="trabajo_presentado_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trabajo_presentado = $em->getRepository('AppBundle:TrabajoPresentado')->findAll();

        return $this->render('entidades/index.html.twig', array(
            'entities' => $trabajo_presentado,
            'entityType' => AppDefaults::TRABAJO_PRESENTADO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new trabajo_presentado entity.
     *
     * @Route("/trabajo_presentado/new", name="trabajo_presentado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trabajo_presentado = new TrabajoPresentado();

        $form = $this->formGenerator('POST', $this->generateUrl('trabajo_presentado_new'), $trabajo_presentado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trabajo_presentado);
            $em->flush();

            return $this->redirectToRoute('trabajo_presentado_show', array('id' => $trabajo_presentado->getId()));
        }

        return $this->render('entidades/new.html.twig', array(
            'entity' => $trabajo_presentado,
            'entityType' => AppDefaults::TRABAJO_PRESENTADO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param TrabajoPresentado $trabajo_presentado
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, TrabajoPresentado $trabajo_presentado)
    {
        $trabajo_presentado == null ? $trabajo_presentado = new TrabajoPresentado() : '';

        $form = $this->createFormBuilder($trabajo_presentado)
            ->add('nombre', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.trabajo_presentado.name'))
            ->add('eventoExterno', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.trabajo_presentado.evento_externo',
                'class' => 'AppBundle:EventoExterno',
                'required' => true))
            ->add('capitalHumano', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.trabajo_presentado.capital_humano',
                'class' => 'AppBundle:CapitalHumano',
                'required' => true))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'entidades.trabajo_presentado.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a trabajo_presentado entity.
     *
     * @Route("/trabajo_presentado/{id}", name="trabajo_presentado_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(TrabajoPresentado $trabajo_presentado)
    {
        $deleteForm = $this->createDeleteForm($trabajo_presentado);

        return $this->render('entidades/show.html.twig', array(
            'entity' => $trabajo_presentado,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::TRABAJO_PRESENTADO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing trabajo_presentado entity.
     *
     * @Route("/trabajo_presentado/{id}/edit", name="trabajo_presentado_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, TrabajoPresentado $trabajo_presentado)
    {
        /*$deleteForm = $this->createDeleteForm($trabajo_presentado);*/
        $editForm = $this->formGenerator('PUT', $this->generateUrl('trabajo_presentado_edit', array(
            'id' => $trabajo_presentado->getId()
        )), $trabajo_presentado);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trabajo_presentado_index');
        }

        return $this->render('entidades/edit.html.twig', array(
            'entity' => $trabajo_presentado,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::TRABAJO_PRESENTADO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a trabajo_presentado entity.
     *
     * @Route("/trabajo_presentado/{id}/delete", name="trabajo_presentado_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $trabajo_presentado = $em->getRepository('AppBundle:TrabajoPresentado')->find($id);
        $em->remove($trabajo_presentado);
        $em->flush();
        $this->addFlash(
            'notice',
            'Trabajo Presentado Eliminado'
        );

        return $this->redirectToRoute('trabajo_presentado_index');
    }

    /**
     * Creates a form to delete a trabajo_presentado entity.
     *
     * @param TrabajoPresentado $trabajo_presentado The trabajo_presentado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TrabajoPresentado $trabajo_presentado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trabajo_presentado_delete', array('id' => $trabajo_presentado->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}