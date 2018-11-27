<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15/11/2018
 * Time: 20:50
 */

namespace AppBundle\Controller;

use AppBundle\Entity\TipoUsuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TipoUsuarioController extends Controller
{
    /**
     * Lists all TipoUsuario entities.
     *
     * @Route("/tipo_usuario", name="tipo_usuario_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipo_usuario = $em->getRepository('AppBundle:TipoUsuario')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $tipo_usuario,
            'entityType' => AppDefaults::TIPO_USUARIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new tipo_usuario entity.
     *
     * @Route("/tipo_usuario/new", name="tipo_usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipo_usuario = new TipoUsuario();

        $form = $this->formGenerator('POST', $this->generateUrl('tipo_usuario_new'), $tipo_usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo_usuario);
            $em->flush();

            return $this->redirectToRoute('tipo_usuario_show', array('id' => $tipo_usuario->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $tipo_usuario,
            'entityType' => AppDefaults::TIPO_USUARIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param TipoUsuario $tipo_usuario
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, TipoUsuario $tipo_usuario)
    {
        $tipo_usuario == null ? $tipo_usuario = new TipoUsuario() : '';

        $form = $this->createFormBuilder($tipo_usuario)
            ->add('tipoUsuario', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_usuario.kind'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'nomenclator.tipo_usuario.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a tipo_usuario entity.
     *
     * @Route("/tipo_usuario/{id}", name="tipo_usuario_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(TipoUsuario $tipo_usuario)
    {
        $deleteForm = $this->createDeleteForm($tipo_usuario);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $tipo_usuario,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::TIPO_USUARIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing tipo_usuario entity.
     *
     * @Route("/tipo_usuario/{id}/edit", name="tipo_usuario_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, TipoUsuario $tipo_usuario)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('tipo_usuario_edit', array(
            'id' => $tipo_usuario->getId()
        )), $tipo_usuario);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipo_usuario_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $tipo_usuario,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::TIPO_USUARIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a tipo_usuario entity.
     *
     * @Route("/tipo_usuario/{id}/delete", name="tipo_usuario_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tipo_usuario = $em->getRepository('AppBundle:TipoUsuario')->find($id);
        $em->remove($tipo_usuario);
        $em->flush();
        $this->addFlash(
            'notice',
            'Tipo de Usuario Eliminado'
        );

        return $this->redirectToRoute('tipo_usuario_index');
    }

    /**
     * Creates a form to delete a tipo_usuario entity.
     *
     * @param TipoUsuario $tipo_usuario The tipo_usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoUsuario $tipo_usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_usuario_delete', array('id' => $tipo_usuario->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}