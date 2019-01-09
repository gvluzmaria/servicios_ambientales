<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19/11/2018
 * Time: 21:04
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CapitalHumano;
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

class CapitalHumanoController extends Controller
{
    /**
     * Lists all CapitalHumano entities.
     *
     * @Route("/capital_humano", name="capital_humano_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $capital_humanos = $em->getRepository('AppBundle:CapitalHumano')->findAll();

        return $this->render('entidades/index.html.twig', array(
            'entities' => $capital_humanos,
            'entityType' => AppDefaults::CAPITAL_HUMANO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new capital_humano entity.
     *
     * @Route("/capital_humano/new", name="capital_humano_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $capital_humano = new CapitalHumano();

        $form = $this->formGenerator('POST', $this->generateUrl('capital_humano_new'), $capital_humano);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($capital_humano);
            $em->flush();

            return $this->redirectToRoute('capital_humano_show', array('id' => $capital_humano->getId()));
        }

        return $this->render('entidades/new.html.twig', array(
            'entity' => $capital_humano,
            'entityType' => AppDefaults::CAPITAL_HUMANO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param CapitalHumano $capital_humano
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, CapitalHumano $capital_humano)
    {
        $capital_humano == null ? $capital_humano = new CapitalHumano() : '';

        $form = $this->createFormBuilder($capital_humano)
            ->add('nombre', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.capital_humano.name'))
            ->add('resumenCurricular', TextareaType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.capital_humano.curriculum'))
            ->add('foto', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.capital_humano.picture'))
            ->add('correo', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.capital_humano.email'))
            ->add('cargo', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.capital_humano.job',
                'class' => 'AppBundle:Cargo',
                'required' => false))
            ->add('categoriaDocente', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.capital_humano.docente_category',
                'class' => 'AppBundle:CategoriaDocente',
                'required' => false))
            ->add('categoriaCientifica', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.capital_humano.cientific_category',
                'class' => 'AppBundle:CategoriaCientifica',
                'required' => false))
            ->add('categoriaInvestigativa', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.capital_humano.investigative_category',
                'class' => 'AppBundle:CategoriaInvestigativa',
                'required' => false))
            ->add('empresa', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.capital_humano.company',
                'class' => 'AppBundle:Empresa',
                'required' => false))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'entidades.capital_humano.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a capital_humano entity.
     *
     * @Route("/capital_humano/{id}", name="capital_humano_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(CapitalHumano $capital_humano)
    {
        $deleteForm = $this->createDeleteForm($capital_humano);

        return $this->render('entidades/show.html.twig', array(
            'entity' => $capital_humano,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::CAPITAL_HUMANO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing capital_humano entity.
     *
     * @Route("/capital_humano/{id}/edit", name="capital_humano_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, CapitalHumano $capital_humano)
    {
        /*$deleteForm = $this->createDeleteForm($capital_humano);*/
        $editForm = $this->formGenerator('PUT', $this->generateUrl('capital_humano_edit', array(
            'id' => $capital_humano->getId()
        )), $capital_humano);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('capital_humano_index');
        }

        return $this->render('entidades/edit.html.twig', array(
            'entity' => $capital_humano,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::CAPITAL_HUMANO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a capital_humano entity.
     *
     * @Route("/capital_humano/{id}/delete", name="capital_humano_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $capital_humano = $em->getRepository('AppBundle:CapitalHumano')->find($id);
        $em->remove($capital_humano);
        $em->flush();
        $this->addFlash(
            'notice',
            'Capital Humano Eliminado'
        );

        return $this->redirectToRoute('capital_humano_index');
    }

    /**
     * Creates a form to delete a capital_humano entity.
     *
     * @param CapitalHumano $capital_humano The capital_humano entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CapitalHumano $capital_humano)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('capital_humano_delete', array('id' => $capital_humano->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}