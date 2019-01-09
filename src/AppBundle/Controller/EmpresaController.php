<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/12/2018
 * Time: 20:02
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Empresa;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\AppDefaults;

class EmpresaController extends Controller
{
    /**
     * Lists all Empresa entities.
     *
     * @Route("/empresa", name="empresa_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $empresa = $em->getRepository('AppBundle:Empresa')->findAll();

        return $this->render('entidades/index.html.twig', array(
            'entities' => $empresa,
            'entityType' => AppDefaults::EMPRESA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new empresa entity.
     *
     * @Route("/empresa/new", name="empresa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $empresa = new Empresa();

        $form = $this->formGenerator('POST', $this->generateUrl('empresa_new'), $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($empresa);
            $em->flush();

            return $this->redirectToRoute('empresa_show', array('id' => $empresa->getId()));
        }

        return $this->render('entidades/new.html.twig', array(
            'entity' => $empresa,
            'entityType' => AppDefaults::EMPRESA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param Empresa $empresa
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, Empresa $empresa)
    {
        $empresa == null ? $empresa = new Empresa() : '';

        $form = $this->createFormBuilder($empresa)
            ->add('nombreEmpresa', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.empresa.name'))
            ->add('correo', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.empresa.email'))
            ->add('telefonos', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.empresa.phone_number'))
            ->add('direccion', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.empresa.address'))
            ->add('infoGeneral', TextareaType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.empresa.info'))
            ->add('objetoSocial', TextareaType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.empresa.social_objective'))
            ->add('estructuraCentro', TextareaType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.empresa.center_structure'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'entidades.empresa.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a empresa entity.
     *
     * @Route("/empresa/{id}", name="empresa_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(Empresa $empresa)
    {
        $deleteForm = $this->createDeleteForm($empresa);

        return $this->render('entidades/show.html.twig', array(
            'entity' => $empresa,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::EMPRESA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing empresa entity.
     *
     * @Route("/empresa/{id}/edit", name="empresa_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, Empresa $empresa)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('empresa_edit', array(
            'id' => $empresa->getId()
        )), $empresa);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('empresa_index');
        }

        return $this->render('entidades/edit.html.twig', array(
            'entity' => $empresa,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::EMPRESA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a empresa entity.
     *
     * @Route("/empresa/{id}/delete", name="empresa_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $empresa = $em->getRepository('AppBundle:Empresa')->find($id);
        $em->remove($empresa);
        $em->flush();
        $this->addFlash(
            'notice',
            'Empresa Eliminada'
        );

        return $this->redirectToRoute('empresa_index');
    }

    /**
     * Creates a form to delete a empresa entity.
     *
     * @param Empresa $empresa The empresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Empresa $empresa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('empresa_delete', array('id' => $empresa->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}