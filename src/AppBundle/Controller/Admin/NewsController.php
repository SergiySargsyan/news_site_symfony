<?php
/**
 * Created by PhpStorm.
 * User: puzzle
 * Date: 21.08.17
 * Time: 3:30
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Category;
use AppBundle\Entity\News;
use AppBundle\Form\CategoryType;
use AppBundle\Form\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    /**
     * @Template()
     * @Route("/admin/news", name = "admin_news_index")
     * @param Request $request
     * @return array | Response
     */
    public function indexAction(Request $request)
    {
        $page = $request->get('page',1);
        $limit = 20;
        $offset = ($page-1)*$limit;
        $news = $this->getDoctrine()->getRepository('AppBundle:News')->findBy( [],['date' => 'DESC'], $limit, $offset);
        dump($news);
        return ['news'=>$news];
    }


    /**
     * @Route("/admin/news-{id}", name="admin_news_show")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function showNewsAction(Request $request)
    {
        $news = $this->getDoctrine()->getRepository('AppBundle:News')->find($request->get('id'));
        $form = $this->createForm(NewsType::class, $news)->getData();

        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->getCommentsForNews($request->get('id'), false);

        return ['news'=>$form, 'comments'=>$comments];
    }


    /**
     * @Route("/admin/news/add", name="admin_news_add")
     * @Template()
     * @param Request $request
     * @return array | Response
     */
    public function createNewsAction(Request $request)
    {
//        $news = new News();
        $form = $this->createForm('AppBundle\Form\NewsType');
        $form->add('Create', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();
            $this->getDoctrine()->getManager()->persist($news);
            $this->getDoctrine()->getManager()->flush();


            $this->addFlash('success', 'The news has been successfully created');
            return $this->redirectToRoute('admin_news_index');
        }

        return['form'=>$form->createView()];

    }

    //todo /news/{id}  and /news/edit-{id}
    /**
     * @Route("/admin/news/edit-{id}", name="admin_news_edit")
     * @Template()
     * @param Request $request
     * @return array | Response
     */
    public function editNewsAction(Request $request)
    {

        $news = $this->getDoctrine()->getRepository('AppBundle:News')->find($request->get('id'));

        if (!$news) {
            $this->addFlash('fail', 'News not found');
            return $this->redirectToRoute('admin_news_index');
        }

        $form = $this->createForm('AppBundle\Form\NewsType', $news);
        $form->add('Save', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dump($news);
//            dump($form->getData());
//            die();
//            $news = $form->getData();
            $this->getDoctrine()->getManager()->persist($news);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'The news has been successfully edited');
            return $this->redirectToRoute('admin_news_index');
        }

        return['form'=>$form->createView()];
    }

    /**
     * @Route("/admin/news/delete/{id}", name="admin_news_delete")
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request)
    {
        $news = $this->getDoctrine()->getRepository('AppBundle:News')->find($request->get('id'));

        if (!$news) {
            $this->addFlash('fail', 'News not found');
            return $this->redirectToRoute('admin_news_index');
        }

        $this->getDoctrine()->getManager()->remove($news);
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'News deleted');
        return $this->redirectToRoute('admin_news_index');
    }


    //todo отложеная новость
}