<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/1/2019
 * Time: 20:23
 */

namespace AppBundle\Controller;

use AppBundle\Entity\NoticiaAmbiental;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class NoticiaAmbientalController extends Controller
{
    /**
     * Lists all NoticiaAmbiental entities.
     *
     * @Route("/noticia_ambiental", name="noticia_ambiental_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $noticia_ambiental = $em->getRepository('AppBundle:NoticiaAmbiental')->findAll();

        return $this->render('entidades/index.html.twig', array(
            'entities' => $noticia_ambiental,
            'entityType' => AppDefaults::NOTICIA_AMBIENTAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Lists all NoticiaAmbiental entities para la vista de usuario.
     *
     * @Route("/noticias_ambientales", name="noticias_ambientales_list", options={"expose"=true})
     * @Method("GET")
     */
    public function listAction()
    {
        $noticia_ambiental = $this->getDoctrine()->getRepository('AppBundle:NoticiaAmbiental')->findTop10NoticiasAmbientales();

        $em = $this->getDoctrine()->getManager();

        $vinculo = $em->getRepository('AppBundle:Vinculo')->findAll();
        $red_social = $em->getRepository('AppBundle:RedSocial')->findAll();

        return $this->render('ambientales/listados.html.twig', array(
            'entities' => $noticia_ambiental,
            'sidebar3' => $vinculo,
            'sidebar4' => $red_social,
            'entityType' => AppDefaults::NOTICIA_AMBIENTAL_TYPE,
            'group' => AppDefaults::GROUP_ENTITIES,
        ));
    }

    /**
     * Detalla una NoticiaAmbiental para la vista de usuario.
     *
     * @Route("/noticias_ambientales/{id}/detail", name="noticia_ambiental_detail", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function detailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $noticia_ambiental = $em->getRepository('AppBundle:NoticiaAmbiental')->find($id);
        $vinculo = $em->getRepository('AppBundle:Vinculo')->findAll();
        $red_social = $em->getRepository('AppBundle:RedSocial')->findAll();

        return $this->render('ambientales/detalles.html.twig', array(
            'entity' => $noticia_ambiental,
            'sidebar3' => $vinculo,
            'sidebar4' => $red_social,
            'entityType' => AppDefaults::NOTICIA_AMBIENTAL_TYPE,
            'group' => AppDefaults::GROUP_ENTITIES,
        ));
    }

    /**
     * Creates a new noticia_ambiental entity.
     *
     * @Route("/noticia_ambiental/new", name="noticia_ambiental_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $noticia_ambiental = new NoticiaAmbiental();

        $form = $this->formGenerator('POST', $this->generateUrl('noticia_ambiental_new'), $noticia_ambiental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($noticia_ambiental);
            $em->flush();

            return $this->redirectToRoute('noticia_ambiental_show', array('id' => $noticia_ambiental->getId()));
        }

        return $this->render('entidades/new.html.twig', array(
            'entity' => $noticia_ambiental,
            'entityType' => AppDefaults::NOTICIA_AMBIENTAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $methodType
     * @param $action
     * @param NoticiaAmbiental $noticia_ambiental
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, NoticiaAmbiental $noticia_ambiental)
    {
        $noticia_ambiental == null ? $noticia_ambiental = new NoticiaAmbiental() : '';

        $form = $this->createFormBuilder($noticia_ambiental)
            ->add('fechaPublicacion', DateType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.noticia_ambiental.publishing_date'))
            ->add('titular', TextareaType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.noticia_ambiental.headline'))
            ->add('descripcion', TextareaType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.noticia_ambiental.description'))
            ->add('usuario', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'entidades.noticia_ambiental.author',
                'class' => 'AppBundle:Usuario',
                'required' => false))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'entidades.noticia_ambiental.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    /**
     * Finds and displays a noticia_ambiental entity.
     *
     * @Route("/noticia_ambiental/{id}", name="noticia_ambiental_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(NoticiaAmbiental $noticia_ambiental)
    {
        $deleteForm = $this->createDeleteForm($noticia_ambiental);

        return $this->render('entidades/show.html.twig', array(
            'entity' => $noticia_ambiental,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::NOTICIA_AMBIENTAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing noticia_ambiental entity.
     *
     * @Route("/noticia_ambiental/{id}/edit", name="noticia_ambiental_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, NoticiaAmbiental $noticia_ambiental)
    {
        $editForm = $this->formGenerator('PUT', $this->generateUrl('noticia_ambiental_edit', array(
            'id' => $noticia_ambiental->getId()
        )), $noticia_ambiental);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('noticia_ambiental_index');
        }

        return $this->render('entidades/edit.html.twig', array(
            'entity' => $noticia_ambiental,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::NOTICIA_AMBIENTAL_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a noticia_ambiental entity.
     *
     * @Route("/noticia_ambiental/{id}/delete", name="noticia_ambiental_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $noticia_ambiental = $em->getRepository('AppBundle:NoticiaAmbiental')->find($id);
        $em->remove($noticia_ambiental);
        $em->flush();
        $this->addFlash(
            'notice',
            'Noticia Ambiental Eliminada'
        );

        return $this->redirectToRoute('noticia_ambiental_index');
    }

    /**
     * Creates a form to delete a noticia_ambiental entity.
     *
     * @param NoticiaAmbiental $noticia_ambiental The noticia_ambiental entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NoticiaAmbiental $noticia_ambiental)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('noticia_ambiental_delete', array('id' => $noticia_ambiental->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}