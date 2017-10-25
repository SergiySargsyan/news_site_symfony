<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class NewsController extends Controller
{

    /**
     * @Route("/", name="news_index")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $categoryes = $this->getDoctrine()->getRepository('AppBundle:Category')->getCategory();
        $arrayCategory = [];

        foreach ( $categoryes as $key => $category){
            $arrayCategory [$category->getName()] = $category->getId();
        }

        $arrayNews = $this->getDoctrine()->getRepository('AppBundle:News')->getBaseNews($arrayCategory);

        return ['NewsList' =>$arrayNews];
    }

    /**
     * @Route("/news/{id}", name="news_show_one")
     * @Template()
     * @param Request $request
     * @return array | Response
     */
    public function showNewsAction(Request $request)
    {

        $this->get('comment')->addComment();

        $id = $request->get('id');
        $news = $this->getDoctrine()->getRepository('AppBundle:News')->find($id);
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->getCommentsForNews($id);
        $visible = !($news->getCategory()->getLimitation());
        $news->setCountView($news->getCountView()+1);
        $this->getDoctrine()->getManager()->persist($news);
        $this->getDoctrine()->getManager()->flush();

//        if($news->getDate() > (new \DateTime()) ){
//            return $this->redirectToRoute('test');
//        }


        $newComment= new Comment();
        $formAddComment = $this->createForm('AppBundle\Form\CommentAddType',$newComment);
        $formAddComment->handleRequest($request);


        if ($formAddComment->isSubmitted() && $formAddComment->isValid()) {
            $comment = $formAddComment->getData();
            $comment->setUser($this->getUser())
                    ->setNews($news)
                    ->setDate(new \DateTime())
                    ->setCountLike(0)
                    ->setCountDislike(0)
                    ->setVisible($visible);

            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
            if  (!$visible){
                $this->addFlash('success', 'comment will add after verification');
            }else {
                $this->addFlash('success', 'comment add');
            }
            return $this->redirectToRoute('news_show_one',['id'=> $id]);
        }


        $formAddCommentAnswer = $this->createForm('AppBundle\Form\CommentAddAnswerType',$newComment);
        $formAddCommentAnswer->handleRequest($request);

        if ($formAddCommentAnswer->isSubmitted() && $formAddCommentAnswer->isValid()) {

            $comment = $formAddCommentAnswer->getData();
            $comment->setUser($this->getUser())
                ->setNews($news)
                ->setDate(new \DateTime())
                ->setCountLike(0)
                ->setCountDislike(0)
                ->setVisible($visible);

//            $this->getDoctrine()->getManager()->persist($comment);
//            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'comment answer add');
            return $this->redirectToRoute('news_show_one',['id'=> $id]);
        }






        return ['news'=>$news,
            'comments'=>$comments,
            'formAddComment' => $formAddComment->createView(),
            'formAddCommentAnswer' => $formAddCommentAnswer->createView()];
    }

    /**
     * @Route("/all", name="news_all")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function allNewsAction(Request $request)
    {
        $query = $this->getDoctrine()->getRepository('AppBundle:News')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return ['pagination' => $pagination];
    }


    /**
     * @param Request $request
     * @Template()
     * @Route("/category/{name}", name="news_category")
     * @return array
     */
    public function categoryAction(Request $request)
    {
        $category = $request->get('name');
        if($request->get('name') == 'Analyst'){
            $news = $this->getDoctrine()->getRepository('AppBundle:News')->getAnalystNews();
            return ['news' => $news, 'category' => $category];
        }

        $news = $this->getDoctrine()->getRepository('AppBundle:News')
                ->getNewsByCategoryName($request->get('name'));
        return ['news' => $news, 'category' => $category];
    }

    /**
     * @param Request $request
     * @Template()
     * @Route("/search/tag={name}", name="news_by_tag")
     * @return array
     */
    public function showNewsByTagAction(Request $request)
    {
        $tag = $request->get('name');

        $news = $this->getDoctrine()->getRepository('AppBundle:News')
            ->getNewsByTag($tag);
        return ['news' => $news, 'tag' => $tag];
    }

    /**
     * @param Request $request
     * @Template()
     * @Route("/search", name="news_search")
     * @return array
     */
    public function searchNewsAction(Request $request)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->getCategoryArray();
        $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->getTagArray();
        $news = null;
        $form = $this->createFormBuilder()->add('tag', ChoiceType::class,
                [
                'choices' => $tag,
                'multiple' => true,
                'expanded' => true,
                ])
            ->add('category', ChoiceType::class,
                [
                'choices' => $category,
                'multiple' => true,
                'expanded' => true,
                ])
            ->add('startDate', DateType::class)
            ->add('endDate', DateType::class)

            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted())
        {
            $data = $form->getData();
            $news = $this->getDoctrine()->getRepository('AppBundle:News')->getSearchNews($data);

        }

        return['form' => $form->createView(), 'news'=>$news];
    }

//    /**
//     * @param Request $request
//     * @Template()
//     * @Route("/line", name="line")
//     * @return array
//     */
//    public function searchLineAction(Request $request)
//    {
////            dump($request);
////       dump($this->getUser());
////        $form = $this->createFormBuilder()->add('line', SearchType::class)->getForm();
////        $pir = "dont work";
////        $form->handleRequest($request);
////        if ($form->isValid())
////        {
////            $pir = "success work";
////        }
//////
//////        dump(handleRequest($request));
//////        ['test'=>"linetesfst", 'form'=>$form->createView()];
////        return ['NewsList' =>$form->createView(), 'pir'=>$pir];
//        return['request' => $request];
//    }
//
}