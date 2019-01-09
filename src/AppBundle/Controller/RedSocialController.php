<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/2018
 * Time: 08:59
 */

namespace AppBundle\Controller;

use AppBundle\Entity\RedSocial;
use AppBundle\Entity\Vinculo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RedSocialController extends Controller
{
    /**
     * Lists all RedSocial entities.
     *
     * @Route("/red_social", name="red_social_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $red_social = $em->getRepository('AppBundle:RedSocial')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $red_social,
            'entityType' => AppDefaults::RED_SOCIAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new red_social entity.
     *
     * @Route("/red_social/new", name="red_social_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $red_social = new RedSocial();

        $form = $this->formGenerator('POST', $this->generateUrl('red_social_new'), $red_social);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($red_social);
            $em->flush();

            return $this->redirectToRoute('red_social_show', array('id' => $red_social->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $red_social,
            'entityType' => AppDefaults::RED_SOCIAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param RedSocial $red_social
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, RedSocial $red_social)
    {
        $red_social == null ? $red_social = new RedSocial() : '';

        $form = $this->createFormBuilder($red_social)
            ->add('redSocial', UrlType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.red_social.redSocial'))
            ->add('info', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.red_social.info'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'nomenclator.red_social.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a red_social entity.
     *
     * @Route("/red_social/{id}", name="red_social_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(RedSocial $red_social)
    {
        $deleteForm = $this->createDeleteForm($red_social);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $red_social,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::RED_SOCIAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing red_social entity.
     *
     * @Route("/red_social/{id}/edit", name="red_social_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, RedSocial $red_social)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('red_social_edit', array(
            'id' => $red_social->getId()
        )), $red_social);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('red_social_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $red_social,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::RED_SOCIAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a red_social entity.
     *
     * @Route("/red_social/{id}/delete", name="red_social_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $red_social = $em->getRepository('AppBundle:RedSocial')->find($id);
        $em->remove($red_social);
        $em->flush();
        $this->addFlash(
            'notice',
            'Red Social Eliminada'
        );

        return $this->redirectToRoute('red_social_index');
    }

    /**
     * Creates a form to delete a red_social entity.
     *
     * @param RedSocial $red_social The red_social entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RedSocial $red_social)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('red_social_delete', array('id' => $red_social->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}