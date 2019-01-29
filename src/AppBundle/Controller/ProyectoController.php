<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28/10/2018
 * Time: 20:44
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Proyecto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProyectoController extends Controller
{
    /**
     * Lists all Proyecto entities.
     *
     * @Route("/proyecto", name="proyecto_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $proyecto = $em->getRepository('AppBundle:Proyecto')->findAll();

        return $this->render('entidades/index.html.twig', array(
            'entities' => $proyecto,
            'entityType' => AppDefaults::PROYECTO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new proyecto entity.
     *
     * @Route("/proyecto/new", name="proyecto_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $proyecto = new Proyecto();

        $form = $this->formGenerator('POST', $this->generateUrl('proyecto_new'), $proyecto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proyecto);
            $em->flush();

            return $this->redirectToRoute('proyecto_show', array('id' => $proyecto->getId()));
        }

        return $this->render('entidades/new.html.twig', array(
            'entity' => $proyecto,
            'entityType' => AppDefaults::PROYECTO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param Proyecto $proyecto
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, Proyecto $proyecto)
    {
        $proyecto == null ? $proyecto = new Proyecto() : '';

        $form = $this->createFormBuilder($proyecto)
            ->add('fechaInicial', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.proyecto.inicial_date'))
            ->add('fechaFinal', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.proyecto.final_date'))
            ->add('guardar', SubmitType::class, array(
                 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                 'label' => 'entidades.proyecto.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a proyecto entity.
     *
     * @Route("/proyecto/{id}", name="proyecto_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(Proyecto $proyecto)
    {
        $deleteForm = $this->createDeleteForm($proyecto);

        return $this->render('entidades/show.html.twig', array(
            'entity' => $proyecto,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::PROYECTO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing proyecto entity.
     *
     * @Route("/proyecto/{id}/edit", name="proyecto_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, Proyecto $proyecto)
    {
        /*$deleteForm = $this->createDeleteForm($categoria_docente);*/
        $editForm = $this->formGenerator('PUT', $this->generateUrl('proyecto_edit', array(
            'id' => $proyecto->getId()
        )), $proyecto);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('proyecto_index');
        }

        return $this->render('entidades/edit.html.twig', array(
            'entity' => $proyecto,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::PROYECTO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a proyecto entity.
     *
     * @Route("/proyecto/{id}/delete", name="proyecto_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $proyecto = $em->getRepository('AppBundle:Proyecto')->find($id);
        $em->remove($proyecto);
        $em->flush();
        $this->addFlash(
            'notice',
            'Proyecto Eliminado'
        );

        return $this->redirectToRoute('proyecto_index');
    }

    /**
     * Creates a form to delete a proyecto entity.
     *
     * @param Proyecto $proyecto The proyecto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Proyecto $proyecto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proyecto_delete', array('id' => $proyecto->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}