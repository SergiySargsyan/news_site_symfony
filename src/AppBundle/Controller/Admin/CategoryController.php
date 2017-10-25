<?php
/**
 * Created by PhpStorm.
 * User: puzzle
 * Date: 21.08.17
 * Time: 3:30
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @Template()
     * @Route("/admin/category", name = "admin_category_index")
     * @param Request $request
     * @return array | Response
     */
    public function indexAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->getCategory();

        return ['categories'=> $categories];
    }



    /**
     * @Template()
     * @Route("/admin/category/add", name = "admin_category_add")
     * @param Request $request
     * @return array | Response
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(CategoryType::class)
            ->add('Add category',SubmitType::class)
            ->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {
            $category = $form->getData();

            $name = $category->getName();
            $name = str_replace("<script>",'', $name);
            $name = str_replace('</script>','', $name);
            $category->setName($name);
            dump($name);
//            die();

            $em = $this->get('doctrine')->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success','Category success add');
            return $this->redirectToRoute('admin_category_index');
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Template()
     * @Route("/admin/category/edit-{id}", name = "admin_category_edit")
     * @param Request $request
     * @return array | Response
     */
    public function editAction(Request $request)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($request->get('id'));

        if (!$category){
            $this->addFlash('fail','Category not exist');
            return $this->redirectToRoute('admin_category_index');
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted())
        {
            $this->getDoctrine()->getManager()->persist($category);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success','Category success edit');
            return $this->redirectToRoute('admin_category_index');
        }

        return ['form' => $form->createView()];
    }
    /**
     * @Route("/admin/category/delete-{id}", name="admin_category_delete")
     * @param Request $request
     * @return Response
     */

    public function deleteAction(Request $request)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->find($request->get('id'));
        if (!$category){
            $this->addFlash('fail','Category not found');
            return $this->redirectToRoute('admin_category_index');
        }
        $this->getDoctrine()->getManager()->remove($category);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success','Category deleted');
        return $this->redirectToRoute('admin_category_index');
    }

}