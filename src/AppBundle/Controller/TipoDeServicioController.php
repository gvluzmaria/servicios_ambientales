<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/11/2018
 * Time: 14:38
 */

namespace AppBundle\Controller;

use AppBundle\Entity\TipoDeServicio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use AppBundle\AppDefaults;
use Symfony\Component\Form\Extension\Core\Type\TextType;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TipoDeServicioController extends Controller
{
    /**
     * Lists all TipoDeServicio entities.
     *
     * @Route("/tipo_servicio", name="tipo_servicio_index", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipo_servicio = $em->getRepository('AppBundle:TipoDeServicio')->findAll();

        return $this->render('nomencladores/index.html.twig', array(
            'entities' => $tipo_servicio,
            'entityType' => AppDefaults::TIPO_SERVICIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Creates a new tipo_servicio entity.
     *
     * @Route("/tipo_servicio/new", name="tipo_servicio_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipo_servicio = new TipoDeServicio();

        $form = $this->formGenerator('POST', $this->generateUrl('tipo_servicio_new'), $tipo_servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $tipo_servicio->getImagen();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // mover el fichero de imagen al directorio donde estas imagenes se amacenan
            try {
                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // actualizar la propiedad Imagen para almacenar el nombre de la imagen en vez de su contenido
            $tipo_servicio->setImagen($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo_servicio);
            $em->flush();

            return $this->redirectToRoute('tipo_servicio_show', array('id' => $tipo_servicio->getId()));
        }

        return $this->render('nomencladores/new.html.twig', array(
            'entity' => $tipo_servicio,
            'entityType' => AppDefaults::TIPO_SERVICIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
            'form' => $form->createView(),
        ));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @param $methodType
     * @param $action
     * @param TipoDeServicio $tipo_servicio
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function formGenerator($methodType, $action, TipoDeServicio $tipo_servicio)
    {
        $tipo_servicio == null ? $tipo_servicio = new TipoDeServicio() : '';

        $form = $this->createFormBuilder($tipo_servicio)
            ->add('nombre', TextType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.name'))
            ->add('descripcion', TextareaType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.description'))
            ->add('pagoEnEfectivo', CheckboxType::class, array(
                'attr' => array('class' => 'xx', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.paymentInCash',
                'required' => false))
            ->add('llevaContrato', CheckboxType::class, array(
                'attr' => array('class' => 'xx', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.contract',
                'required' => false))
            ->add('precioCUP', NumberType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.priceCUP'))
            ->add('precioCUC', NumberType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.priceCUC'))
            ->add('subordinadoA', EntityType::class, array(
                'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.subordinatedTo',
                'class' => 'AppBundle:TipoDeServicio',
                'required' => false))
            ->add('seMuestraEnPagInicial', CheckboxType::class, array(
                'attr' => array('class' => 'xx', 'style' => 'margin-bottom:15px'),
                'label' => 'nomenclator.tipo_servicio.isShown',
                'required' => false))
            ->add('imagen', FileType::class, array(
                'label' => 'nomenclator.tipo_servicio.image'))
            ->add('guardar', SubmitType::class, array(
                    'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px'),
                    'label' => 'nomenclator.tipo_servicio.save')
            )
            ->setAction($action)
            ->setMethod($methodType)
            ->getForm();

        return $form;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => TipoDeServicio::class,
        ));
    }

    /**
     * Finds and displays a tipo_servicio entity.
     *
     * @Route("/tipo_servicio/{id}", name="tipo_servicio_show", requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function showAction(TipoDeServicio $tipo_servicio)
    {
        $deleteForm = $this->createDeleteForm($tipo_servicio);

        return $this->render('nomencladores/show.html.twig', array(
            'entity' => $tipo_servicio,
            'delete_form' => $deleteForm->createView(),
            'entityType' => AppDefaults::TIPO_SERVICIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Displays a form to edit an existing tipo_servicio entity.
     *
     * @Route("/tipo_servicio/{id}/edit", name="tipo_servicio_edit", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, TipoDeServicio $tipo_servicio)
    {
        $tipo_servicio->setImagen(
            new File($this->getParameter('brochures_directory').'/'.$tipo_servicio->getImagen())
        );

        $editForm = $this->formGenerator('PUT', $this->generateUrl('tipo_servicio_edit', array(
            'id' => $tipo_servicio->getId()
        )), $tipo_servicio);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $tipo_servicio->getImagen();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // mover el fichero de imagen al directorio donde estas imagenes se amacenan
            try {
                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // actualizar la propiedad Imagen para almacenar el nombre de la imagen en vez de su contenido
            $tipo_servicio->setImagen($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipo_servicio_index');
        }

        return $this->render('nomencladores/edit.html.twig', array(
            'entity' => $tipo_servicio,
            'edit_form' => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
            'entityType' => AppDefaults::TIPO_SERVICIO_TYPE,
            /*'group' => NomencladorDefaults::GROUP_ENTITIES,*/
        ));
    }

    /**
     * Deletes a tipo_servicio entity.
     *
     * @Route("/tipo_servicio/{id}/delete", name="tipo_servicio_delete", options={"expose"=true}, requirements={
     *     "id": "\d+"
     * })
     * @Method("GET")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tipo_servicio = $em->getRepository('AppBundle:TipoDeServicio')->find($id);

        try {
            $em->remove($tipo_servicio);
            $em->flush();
            $this->addFlash(
                'notice',
                'Tipo de Servicio Eliminado'
            );
        }
        catch (\Exception $e) {
            $this->addFlash(
                'notice',
                'El tipo de servicio no pudo ser eliminado pues existen tipos de servicio subordinados a él.'
            );
        }
        return $this->redirectToRoute('tipo_servicio_index');
    }

    /**
     * Creates a form to delete a tipo_servicio entity.
     *
     * @param TipoDeServicio $tipo_servicio The tipo_servicio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoDeServicio $tipo_servicio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_servicio_delete', array('id' => $tipo_servicio->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}