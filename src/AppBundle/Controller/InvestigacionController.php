<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19/11/2018
 * Time: 21:04
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Investigacion;
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

class InvestigacionController extends Controller
{
    /**
     * Lists all Investigacion entities.
     *
     * @Route("/investigacion", name="investigacion_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $investigacion = $em->getRepository('AppBundle:Investigacion')->findAll();

        return $this->render('entidades/index.html.twig', array(
            'entities' => $investigacion,
            'entityType' => AppDefaults::INVESTIGACION,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new investigacion entity.
     *
     * @Route("/investigacion/new", name="investigacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $investigacion = new Investigacion();

        $form = $this->formGenerator('POST', $this->generateUrl('investigacion_new'), $investigacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($investigacion);
            $em->flush();

            return $this->redirectToRoute('investigacion_show', array('id' => $investigacion->getId()));
        }

        return $this->render('entidades/new.html.twig', array(
            'entity' => $investigacion,
            'entityType' => AppDefaults::INVESTIGACION,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param Investigacion $investigacion
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, Investigacion $investigacion)
    {
        $investigacion == null ? $investigacion = new Investigacion() : '';

        $form = $this->createFormBuilder($investigacion)
            ->add('nombreInvestigacion', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.investigacion.name'))
            ->add('resultados', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.investigacion.resultado'))
            ->add('empresa', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.investigacion.empresa',
                'class' => 'AppBundle:Empresa',
                'required' => true))
            ->add('capitalHumano', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.investigacion.capital_humano',
                'class' => 'AppBundle:CapitalHumano',
                'required' => true))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'entidades.investigacion.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a investigacion entity.
     *
     * @Route("/investigacion/{id}", name="investigacion_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(Investigacion $investigacion)
    {
        $deleteForm = $this->createDeleteForm($investigacion);

        return $this->render('entidades/show.html.twig', array(
            'entity' => $investigacion,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::INVESTIGACION,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing investigacion entity.
     *
     * @Route("/investigacion/{id}/edit", name="investigacion_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, Investigacion $investigacion)
    {
        /*$deleteForm = $this->createDeleteForm($trabajo_presentado);*/
        $editForm = $this->formGenerator('PUT', $this->generateUrl('investigacion_edit', array(
            'id' => $investigacion->getId()
        )), $investigacion);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('investigacion_index');
        }

        return $this->render('entidades/edit.html.twig', array(
            'entity' => $investigacion,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::INVESTIGACION,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a investigacion entity.
     *
     * @Route("/investigacion/{id}/delete", name="investigacion_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $investigacion = $em->getRepository('AppBundle:Investigacion')->find($id);
        $em->remove($investigacion);
        $em->flush();
        $this->addFlash(
            'notice',
            'Investigación Eliminada'
        );

        return $this->redirectToRoute('investigacion_index');
    }

    /**
     * Creates a form to delete a investigacion entity.
     *
     * @param Investigacion $investigacion The investigacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Investigacion $investigacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('investigacion_delete', array('id' => $investigacion->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}