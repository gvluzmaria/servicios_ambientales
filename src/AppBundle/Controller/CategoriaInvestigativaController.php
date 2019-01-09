<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/2018
 * Time: 08:59
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CategoriaInvestigativa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoriaInvestigativaController extends Controller
{
    /**
     * Lists all CategoriaInvestigativa entities.
     *
     * @Route("/categoria_investigativa", name="categoria_investigativa_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoria_investigativa = $em->getRepository('AppBundle:CategoriaInvestigativa')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $categoria_investigativa,
            'entityType' => AppDefaults::CATEGORIA_INVESTIGATIVA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new categoria_investigativa entity.
     *
     * @Route("/categoria_investigativa/new", name="categoria_investigativa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categoria_investigativa = new CategoriaInvestigativa();

        $form = $this->formGenerator('POST', $this->generateUrl('categoria_investigativa_new'), $categoria_investigativa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoria_investigativa);
            $em->flush();

            return $this->redirectToRoute('categoria_investigativa_show', array('id' => $categoria_investigativa->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $categoria_investigativa,
            'entityType' => AppDefaults::CATEGORIA_INVESTIGATIVA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param CategoriaInvestigativa $categoria_investigativa
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, CategoriaInvestigativa $categoria_investigativa)
    {
        $categoria_investigativa == null ? $categoria_investigativa = new CategoriaInvestigativa() : '';

        $form = $this->createFormBuilder($categoria_investigativa)
            ->add('descripcion', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.categoria_investigativa.description'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'nomenclator.categoria_investigativa.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a categoria_investigativa entity.
     *
     * @Route("/categoria_investigativa/{id}", name="categoria_investigativa_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(CategoriaInvestigativa $categoria_investigativa)
    {
        $deleteForm = $this->createDeleteForm($categoria_investigativa);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $categoria_investigativa,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::CATEGORIA_INVESTIGATIVA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing categoria_investigativa entity.
     *
     * @Route("/categoria_investigativa/{id}/edit", name="categoria_investigativa_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, CategoriaInvestigativa $categoria_investigativa)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('categoria_investigativa_edit', array(
            'id' => $categoria_investigativa->getId()
        )), $categoria_investigativa);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoria_investigativa_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $categoria_investigativa,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::CATEGORIA_INVESTIGATIVA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a categoria_investigativa entity.
     *
     * @Route("/categoria_investigativa/{id}/delete", name="categoria_investigativa_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categoria_investigativa = $em->getRepository('AppBundle:CategoriaInvestigativa')->find($id);
        $em->remove($categoria_investigativa);
        $em->flush();
        $this->addFlash(
            'notice',
            'Categoria Investigativa Eliminada'
        );

        return $this->redirectToRoute('categoria_investigativa_index');
    }

    /**
     * Creates a form to delete a categoria_investigativa entity.
     *
     * @param CategoriaInvestigativa $categoria_investigativa The categoria_investigativa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategoriaInvestigativa $categoria_investigativa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_investigativa_delete', array('id' => $categoria_investigativa->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}