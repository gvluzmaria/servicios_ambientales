<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/2018
 * Time: 08:59
 */

namespace AppBundle\Controller;

use AppBundle\Entity\EfemerideAmbiental;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EfemerideAmbientalController extends Controller
{
    /**
     * Lists all EfemerideAmbiental entities.
     *
     * @Route("/efemeride_ambiental", name="efemeride_ambiental_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $efemeride_ambiental = $em->getRepository('AppBundle:EfemerideAmbiental')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $efemeride_ambiental,
            'entityType' => AppDefaults::EFEMERIDE_AMBIENTAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new efemeride_ambiental entity.
     *
     * @Route("/efemeride_ambiental/new", name="efemeride_ambiental_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $efemeride_ambiental = new EfemerideAmbiental();

        $form = $this->formGenerator('POST', $this->generateUrl('efemeride_ambiental_new'), $efemeride_ambiental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($efemeride_ambiental);
            $em->flush();

            return $this->redirectToRoute('efemeride_ambiental_show', array('id' => $efemeride_ambiental->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $efemeride_ambiental,
            'entityType' => AppDefaults::EFEMERIDE_AMBIENTAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param EfemerideAmbiental $efemeride_ambiental
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, EfemerideAmbiental $efemeride_ambiental)
    {
        $efemeride_ambiental == null ? $efemeride_ambiental = new EfemerideAmbiental() : '';

        $form = $this->createFormBuilder($efemeride_ambiental)
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.efemeride_ambiental.date'
            ])
            ->add('titularEfemeride', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.efemeride_ambiental.titular'))
            ->add('efemeride', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.efemeride_ambiental.efemeride'))
            ->add('tipoDisenno', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.efemeride_ambiental.type'))
            ->add('foto', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.efemeride_ambiental.photo'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'nomenclator.efemeride_ambiental.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a efemeride_ambiental entity.
     *
     * @Route("/efemeride_ambiental/{id}", name="efemeride_ambiental_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(EfemerideAmbiental $efemeride_ambiental)
    {
        $deleteForm = $this->createDeleteForm($efemeride_ambiental);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $efemeride_ambiental,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::EFEMERIDE_AMBIENTAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing efemeride_ambiental entity.
     *
     * @Route("/efemeride_ambiental/{id}/edit", name="efemeride_ambiental_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, EfemerideAmbiental $efemeride_ambiental)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('efemeride_ambiental_edit', array(
            'id' => $efemeride_ambiental->getId()
        )), $efemeride_ambiental);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('efemeride_ambiental_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $efemeride_ambiental,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::EFEMERIDE_AMBIENTAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a efemeride_ambiental entity.
     *
     * @Route("/efemeride_ambiental/{id}/delete", name="efemeride_ambiental_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $efemeride_ambiental = $em->getRepository('AppBundle:EfemerideAmbiental')->find($id);
        $em->remove($efemeride_ambiental);
        $em->flush();
        $this->addFlash(
            'notice',
            'Efemeride Ambiental Eliminada'
        );

        return $this->redirectToRoute('efemeride_ambiental_index');
    }

    /**
     * Creates a form to delete a efemeride_ambiental entity.
     *
     * @param EfemerideAmbiental $efemeride_ambiental The efemeride_ambiental entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EfemerideAmbiental $efemeride_ambiental)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('efemeride_ambiental_delete', array('id' => $efemeride_ambiental->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}