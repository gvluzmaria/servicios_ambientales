<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 1/1/2019
 * Time: 23:16
 */

namespace AppBundle\Controller;

use AppBundle\Entity\EventoCSA;
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

class EventoCSAController extends Controller
{
    /**
     * Lists all EventoCSA entities.
     *
     * @Route("/eventocsa", name="eventocsa_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eventocsa = $em->getRepository('AppBundle:EventoCSA')->findAll();

        return $this->render('entidades/index.html.twig', array(
            'entities' => $eventocsa,
            'entityType' => AppDefaults::EVENTOCSA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new eventocsa entity.
     *
     * @Route("/eventocsa/new", name="eventocsa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $eventocsa = new EventoCSA();

        $form = $this->formGenerator('POST', $this->generateUrl('eventocsa_new'), $eventocsa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eventocsa);
            $em->flush();

            return $this->redirectToRoute('eventocsa_show', array('id' => $eventocsa->getId()));
        }

        return $this->render('entidades/new.html.twig', array(
            'entity' => $eventocsa,
            'entityType' => AppDefaults::EVENTOCSA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param EventoCSA $eventocsa
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, EventoCSA $eventocsa)
    {
        $eventocsa == null ? $eventocsa = new EventoCSA() : '';

        $form = $this->createFormBuilder($eventocsa)
            ->add('nombre', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.eventocsa.name'))
            ->add('fechaInicial', DateType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.eventocsa.init_date'))
            ->add('fechaFinal', DateType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.eventocsa.end_date'))
            ->add('descripcion', TextareaType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.eventocsa.description'))
            ->add('contactos', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.eventocsa.contacts'))
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
     * Finds and displays a eventocsa entity.
     *
     * @Route("/eventocsa/{id}", name="eventocsa_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(EventoCSA $eventocsa)
    {
        $deleteForm = $this->createDeleteForm($eventocsa);

        return $this->render('entidades/show.html.twig', array(
            'entity' => $eventocsa,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::EVENTOCSA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing eventocsa entity.
     *
     * @Route("/eventocsa/{id}/edit", name="eventocsa_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, EventoCSA $eventocsa)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('eventocsa_edit', array(
            'id' => $eventocsa->getId()
        )), $eventocsa);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eventocsa_index');
        }

        return $this->render('entidades/edit.html.twig', array(
            'entity' => $eventocsa,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::EVENTOCSA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a eventocsa entity.
     *
     * @Route("/eventocsa/{id}/delete", name="eventocsa_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $eventocsa = $em->getRepository('AppBundle:EventoCSA')->find($id);
        $em->remove($eventocsa);
        $em->flush();
        $this->addFlash(
            'notice',
            'Evento CSA Eliminado'
        );

        return $this->redirectToRoute('eventocsa_index');
    }

    /**
     * Creates a form to delete a eventocsa entity.
     *
     * @param EventoCSA $eventocsa The eventocsa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EventoCSA $eventocsa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eventocsa_delete', array('id' => $eventocsa->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}