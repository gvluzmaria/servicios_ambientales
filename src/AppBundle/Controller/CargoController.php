<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19/11/2018
 * Time: 20:36
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Cargo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CargoController extends Controller
{
    /**
     * Lists all Cargo entities.
     *
     * @Route("/cargo", name="cargo_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cargos = $em->getRepository('AppBundle:Cargo')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $cargos,
            'entityType' => AppDefaults::CARGO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new cargo entity.
     *
     * @Route("/cargo/new", name="cargo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cargo = new Cargo();

        $form = $this->formGenerator('POST', $this->generateUrl('cargo_new'), $cargo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cargo);
            $em->flush();

            return $this->redirectToRoute('cargo_show', array('id' => $cargo->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $cargo,
            'entityType' => AppDefaults::CARGO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param Cargo $cargo
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, Cargo $cargo)
    {
        $cargo == null ? $cargo = new Cargo() : '';

        $form = $this->createFormBuilder($cargo)
            ->add('descripcion', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.cargo.description'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'nomenclator.cargo.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a cargo entity.
     *
     * @Route("/cargo/{id}", name="cargo_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(Cargo $cargo)
    {
        $deleteForm = $this->createDeleteForm($cargo);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $cargo,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::CARGO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing cargo entity.
     *
     * @Route("/cargo/{id}/edit", name="cargo_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, Cargo $cargo)
    {
        /*$deleteForm = $this->createDeleteForm($cargo);*/
        $editForm = $this->formGenerator('PUT', $this->generateUrl('cargo_edit', array(
            'id' => $cargo->getId()
        )), $cargo);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cargo_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $cargo,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::CARGO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a cargo entity.
     *
     * @Route("/cargo/{id}/delete", name="cargo_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cargo = $em->getRepository('AppBundle:Cargo')->find($id);
        $em->remove($cargo);
        $em->flush();
        $this->addFlash(
            'notice',
            'Cargo Eliminado'
        );

        return $this->redirectToRoute('cargo_index');
    }

    /**
     * Creates a form to delete a cargo entity.
     *
     * @param Cargo $cargo The cargo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cargo $cargo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cargo_delete', array('id' => $cargo->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}