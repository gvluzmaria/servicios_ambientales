<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 1/1/2019
 * Time: 23:16
 */

namespace AppBundle\Controller;

use AppBundle\Entity\EventoExterno;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\AppDefaults;

class EventoExternoController extends Controller
{
    /**
     * Lists all EventoExterno entities.
     *
     * @Route("/evento_externo", name="evento_externo_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evento_externo = $em->getRepository('AppBundle:EventoExterno')->findAll();

        return $this->render('entidades/index.html.twig', array(
            'entities' => $evento_externo,
            'entityType' => AppDefaults::EVENTOEXTERNO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new evento_externo entity.
     *
     * @Route("/evento_externo/new", name="evento_externo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $evento_externo = new EventoExterno();

        $form = $this->formGenerator('POST', $this->generateUrl('evento_externo_new'), $evento_externo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evento_externo);
            $em->flush();

            return $this->redirectToRoute('evento_externo_show', array('id' => $evento_externo->getId()));
        }

        return $this->render('entidades/new.html.twig', array(
            'entity' => $evento_externo,
            'entityType' => AppDefaults::EVENTOEXTERNO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param EventoExterno $evento_externo
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, EventoExterno $evento_externo)
    {
        $evento_externo == null ? $evento_externo = new EventoExterno() : '';

        $form = $this->createFormBuilder($evento_externo)
            ->add('nombre', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.eventocsa.name'))
            ->add('fechaInicial', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.eventocsa.init_date'))
            ->add('fechaFinal', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.eventocsa.end_date'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'entidades.eventocsa.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a evento_externo entity.
     *
     * @Route("/evento_externo/{id}", name="evento_externo_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(EventoExterno $evento_externo)
    {
        $deleteForm = $this->createDeleteForm($evento_externo);

        return $this->render('entidades/show.html.twig', array(
            'entity' => $evento_externo,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::EVENTOEXTERNO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing evento_externo entity.
     *
     * @Route("/evento_externo/{id}/edit", name="evento_externo_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, EventoExterno $evento_externo)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('evento_externo_edit', array(
            'id' => $evento_externo->getId()
        )), $evento_externo);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evento_externo_index');
        }

        return $this->render('entidades/edit.html.twig', array(
            'entity' => $evento_externo,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::EVENTOEXTERNO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a evento_externo entity.
     *
     * @Route("/evento_externo/{id}/delete", name="evento_externo_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $evento_externo = $em->getRepository('AppBundle:EventoExterno')->find($id);
        $em->remove($evento_externo);
        $em->flush();
        $this->addFlash(
            'notice',
            'Evento Externo Eliminado'
        );

        return $this->redirectToRoute('evento_externo_index');
    }

    /**
     * Creates a form to delete a evento_externo entity.
     *
     * @param EventoExterno $evento_externo The evento_externo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EventoExterno $evento_externo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evento_externo_delete', array('id' => $evento_externo->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}