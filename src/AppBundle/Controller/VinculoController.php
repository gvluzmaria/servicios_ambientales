<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/2018
 * Time: 08:59
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Vinculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VinculoController extends Controller
{
    /**
     * Lists all Vinculo entities.
     *
     * @Route("/vinculo", name="vinculo_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vinculo = $em->getRepository('AppBundle:Vinculo')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $vinculo,
            'entityType' => AppDefaults::VINCULO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new vinculo entity.
     *
     * @Route("/vinculo/new", name="vinculo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $vinculo = new Vinculo();

        $form = $this->formGenerator('POST', $this->generateUrl('vinculo_new'), $vinculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vinculo);
            $em->flush();

            return $this->redirectToRoute('vinculo_show', array('id' => $vinculo->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $vinculo,
            'entityType' => AppDefaults::VINCULO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param Vinculo $vinculo
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, Vinculo $vinculo)
    {
        $vinculo == null ? $vinculo = new Vinculo() : '';

        $form = $this->createFormBuilder($vinculo)
            ->add('vinculo', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.vinculo.ref'))
            ->add('nombre', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.vinculo.name'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'nomenclator.vinculo.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a vinculo entity.
     *
     * @Route("/vinculo/{id}", name="vinculo_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(Vinculo $vinculo)
    {
        $deleteForm = $this->createDeleteForm($vinculo);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $vinculo,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::VINCULO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing vinculo entity.
     *
     * @Route("/vinculo/{id}/edit", name="vinculo_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, Vinculo $vinculo)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('vinculo_edit', array(
            'id' => $vinculo->getId()
        )), $vinculo);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vinculo_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $vinculo,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::VINCULO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a vinculo entity.
     *
     * @Route("/vinculo/{id}/delete", name="vinculo_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $vinculo = $em->getRepository('AppBundle:Vinculo')->find($id);
        $em->remove($vinculo);
        $em->flush();
        $this->addFlash(
            'notice',
            'Vínculo Eliminado'
        );

        return $this->redirectToRoute('vinculo_index');
    }

    /**
     * Creates a form to delete a vinculo entity.
     *
     * @param Vinculo $vinculo The vinculo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vinculo $vinculo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vinculo_delete', array('id' => $vinculo->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}