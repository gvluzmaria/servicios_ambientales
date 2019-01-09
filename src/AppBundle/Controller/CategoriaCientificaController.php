<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/2018
 * Time: 08:59
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CategoriaCientifica;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoriaCientificaController extends Controller
{
    /**
     * Lists all CategoriaCientifica entities.
     *
     * @Route("/categoria_cientifica", name="categoria_cientifica_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoria_cientifica = $em->getRepository('AppBundle:CategoriaCientifica')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $categoria_cientifica,
            'entityType' => AppDefaults::CATEGORIA_CIENTIFICA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new categoria_cientifica entity.
     *
     * @Route("/categoria_cientifica/new", name="categoria_cientifica_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categoria_cientifica = new CategoriaCientifica();

        $form = $this->formGenerator('POST', $this->generateUrl('categoria_cientifica_new'), $categoria_cientifica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoria_cientifica);
            $em->flush();

            return $this->redirectToRoute('categoria_cientifica_show', array('id' => $categoria_cientifica->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $categoria_cientifica,
            'entityType' => AppDefaults::CATEGORIA_CIENTIFICA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param CategoriaCientifica $categoria_cientifica
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, CategoriaCientifica $categoria_cientifica)
    {
        $categoria_cientifica == null ? $categoria_cientifica = new CategoriaCientifica() : '';

        $form = $this->createFormBuilder($categoria_cientifica)
            ->add('descripcion', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.categoria_cientifica.description'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'nomenclator.categoria_cientifica.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a categoria_cientifica entity.
     *
     * @Route("/categoria_cientifica/{id}", name="categoria_cientifica_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(CategoriaCientifica $categoria_cientifica)
    {
        $deleteForm = $this->createDeleteForm($categoria_cientifica);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $categoria_cientifica,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::CATEGORIA_CIENTIFICA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing categoria_cientifica entity.
     *
     * @Route("/categoria_cientifica/{id}/edit", name="categoria_cientifica_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, CategoriaCientifica $categoria_cientifica)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('categoria_cientifica_edit', array(
            'id' => $categoria_cientifica->getId()
        )), $categoria_cientifica);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoria_cientifica_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $categoria_cientifica,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::CATEGORIA_CIENTIFICA_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a categoria_cientifica entity.
     *
     * @Route("/categoria_cientifica/{id}/delete", name="categoria_cientifica_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categoria_cientifica = $em->getRepository('AppBundle:CategoriaCientifica')->find($id);
        $em->remove($categoria_cientifica);
        $em->flush();
        $this->addFlash(
            'notice',
            'Categoria Cientifica Eliminada'
        );

        return $this->redirectToRoute('categoria_cientifica_index');
    }

    /**
     * Creates a form to delete a categoria_cientifica entity.
     *
     * @param CategoriaCientifica $categoria_cientifica The categoria_cientifica entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategoriaCientifica $categoria_cientifica)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_cientifica_delete', array('id' => $categoria_cientifica->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}