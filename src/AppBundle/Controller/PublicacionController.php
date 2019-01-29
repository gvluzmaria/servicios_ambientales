<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/1/2019
 * Time: 20:03
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Publicacion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PublicacionController extends Controller
{
    /**
     * Lists all Publicacion entities.
     *
     * @Route("/publicacion", name="publicacion_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publicacion = $em->getRepository('AppBundle:Publicacion')->findAll();

        return $this->render('entidades/index.html.twig', array(
            'entities' => $publicacion,
            'entityType' => AppDefaults::PUBLICACION_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new publicacion entity.
     *
     * @Route("/publicacion/new", name="publicacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $publicacion = new Publicacion();

        $form = $this->formGenerator('POST', $this->generateUrl('publicacion_new'), $publicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publicacion);
            $em->flush();

            return $this->redirectToRoute('publicacion_show', array('id' => $publicacion->getId()));
        }

        return $this->render('entidades/new.html.twig', array(
            'entity' => $publicacion,
            'entityType' => AppDefaults::PUBLICACION_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param Publicacion $publicacion
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, Publicacion $publicacion)
    {
        $publicacion == null ? $publicacion = new Publicacion() : '';

        $form = $this->createFormBuilder($publicacion)
            ->add('nombrePublicacion', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.publicacion.name'))
            ->add('empresa', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.publicacion.company',
                'class' => 'AppBundle:Empresa',
                'required' => false))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'entidades.publicacion.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a publicacion entity.
     *
     * @Route("/publicacion/{id}", name="publicacion_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(Publicacion $publicacion)
    {
        $deleteForm = $this->createDeleteForm($publicacion);

        return $this->render('entidades/show.html.twig', array(
            'entity' => $publicacion,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::PUBLICACION_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing publicacion entity.
     *
     * @Route("/publicacion/{id}/edit", name="publicacion_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, Publicacion $publicacion)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('publicacion_edit', array(
            'id' => $publicacion->getId()
        )), $publicacion);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publicacion_index');
        }

        return $this->render('entidades/edit.html.twig', array(
            'entity' => $publicacion,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::PUBLICACION_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a publicacion entity.
     *
     * @Route("/publicacion/{id}/delete", name="publicacion_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $publicacion = $em->getRepository('AppBundle:Publicacion')->find($id);
        $em->remove($publicacion);
        $em->flush();
        $this->addFlash(
            'notice',
            'Publicación Eliminada'
        );

        return $this->redirectToRoute('publicacion_index');
    }

    /**
     * Creates a form to delete a publicacion entity.
     *
     * @param Publicacion $publicacion The publicacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publicacion $publicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('publicacion_delete', array('id' => $publicacion->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}