<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28/10/2018
 * Time: 20:44
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CategoriaDocente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoriaDocenteController extends Controller
{
    /**
     * Lists all CategoriaDocente entities.
     *
     * @Route("/categoria_docente", name="categoria_docente_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoriasDocentes = $em->getRepository('AppBundle:CategoriaDocente')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $categoriasDocentes,
            'entityType' => AppDefaults::CATEGORIA_DOCENTE_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new categoria_docente entity.
     *
     * @Route("/categoria_docente/new", name="categoria_docente_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categoriaDocente = new CategoriaDocente();

        $form = $this->formGenerator('POST', $this->generateUrl('categoria_docente_new'), $categoriaDocente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoriaDocente);
            $em->flush();

            return $this->redirectToRoute('categoria_docente_show', array('id' => $categoriaDocente->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $categoriaDocente,
            'entityType' => AppDefaults::CATEGORIA_DOCENTE_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param CategoriaDocente $categoria_docente
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, CategoriaDocente $categoria_docente)
    {
        $categoria_docente == null ? $categoria_docente = new CategoriaDocente() : '';

        $form = $this->createFormBuilder($categoria_docente)
            ->add('descripcion', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.categoria_docente.description'))
            ->add('guardar', SubmitType::class, array(
                 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                 'label' => 'nomenclator.categoria_docente.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a categoria_docente entity.
     *
     * @Route("/categoria_docente/{id}", name="categoria_docente_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(CategoriaDocente $categoria_docente)
    {
        $deleteForm = $this->createDeleteForm($categoria_docente);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $categoria_docente,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::CATEGORIA_DOCENTE_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing categoria_docente entity.
     *
     * @Route("/categoria_docente/{id}/edit", name="categoria_docente_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, CategoriaDocente $categoria_docente)
    {
        /*$deleteForm = $this->createDeleteForm($categoria_docente);*/
        $editForm = $this->formGenerator('PUT', $this->generateUrl('categoria_docente_edit', array(
            'id' => $categoria_docente->getId()
        )), $categoria_docente);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoria_docente_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $categoria_docente,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::CATEGORIA_DOCENTE_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a categoria_docente entity.
     *
     * @Route("/categoria_docente/{id}/delete", name="categoria_docente_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categoria_docente = $em->getRepository('AppBundle:CategoriaDocente')->find($id);
        $em->remove($categoria_docente);
        $em->flush();
        $this->addFlash(
            'notice',
            'Categoría Docente Eliminada'
        );

        return $this->redirectToRoute('categoria_docente_index');
    }

    /**
     * Creates a form to delete a categoria_docente entity.
     *
     * @param CategoriaDocente $categoria_docente The categoria_docente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategoriaDocente $categoria_docente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_docente_delete', array('id' => $categoria_docente->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}