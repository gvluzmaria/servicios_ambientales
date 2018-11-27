<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/2018
 * Time: 14:38
 */

namespace AppBundle\Controller;

use AppBundle\Entity\TipoDeServicio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TipoDeServicioController extends Controller
{
    /**
     * Lists all TipoDeServicio entities.
     *
     * @Route("/tipo_servicio", name="tipo_servicio_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipo_servicio = $em->getRepository('AppBundle:TipoDeServicio')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $tipo_servicio,
            'entityType' => AppDefaults::TIPO_SERVICIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new tipo_servicio entity.
     *
     * @Route("/tipo_servicio/new", name="tipo_servicio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipo_servicio = new TipoDeServicio();

        $form = $this->formGenerator('POST', $this->generateUrl('tipo_servicio_new'), $tipo_servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo_servicio);
            $em->flush();

            return $this->redirectToRoute('tipo_servicio_show', array('id' => $tipo_servicio->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $tipo_servicio,
            'entityType' => AppDefaults::TIPO_SERVICIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param TipoDeServicio $tipo_servicio
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, TipoDeServicio $tipo_servicio)
    {
        $tipo_servicio == null ? $tipo_servicio = new TipoDeServicio() : '';

        $form = $this->createFormBuilder($tipo_servicio)
            ->add('nombre', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.name'))
            ->add('pagoEnEfectivo', CheckboxType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.paymentInCash'))
            ->add('llevaContrato', CheckboxType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.contract'))
            ->add('precioCUP', NumberType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.priceCUP'))
            ->add('precioCUC', NumberType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.priceCUC'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'nomenclator.tipo_servicio.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a tipo_servicio entity.
     *
     * @Route("/tipo_servicio/{id}", name="tipo_servicio_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(TipoDeServicio $tipo_servicio)
    {
        $deleteForm = $this->createDeleteForm($tipo_servicio);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $tipo_servicio,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::TIPO_SERVICIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing tipo_servicio entity.
     *
     * @Route("/tipo_servicio/{id}/edit", name="tipo_servicio_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, TipoDeServicio $tipo_servicio)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('tipo_servicio_edit', array(
            'id' => $tipo_servicio->getId()
        )), $tipo_servicio);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipo_servicio_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $tipo_servicio,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::TIPO_SERVICIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a tipo_servicio entity.
     *
     * @Route("/tipo_servicio/{id}/delete", name="tipo_servicio_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tipo_servicio = $em->getRepository('AppBundle:TipoDeServicio')->find($id);
        $em->remove($tipo_servicio);
        $em->flush();
        $this->addFlash(
            'notice',
            'Tipo de Servicio Eliminado'
        );

        return $this->redirectToRoute('tipo_servicio_index');
    }

    /**
     * Creates a form to delete a tipo_servicio entity.
     *
     * @param TipoDeServicio $tipo_servicio The tipo_servicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoDeServicio $tipo_servicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_servicio_delete', array('id' => $tipo_servicio->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}