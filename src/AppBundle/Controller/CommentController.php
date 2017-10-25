<?php
/**
 * Created by PhpStorm.
 * User: puzzle
 * Date: 01.08.17
 * Time: 19:53
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Comment;
use AppBundle\Entity\Rating;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @Template()
     * @param Request $request
     * @return array | Response
     */
    public function addCommentAction(Request $request)
    {
        //todo singletone для тега и категории
//        dump($request);
        $news = $this->getDoctrine()->getRepository('AppBundle:News')->find(108);

        $newComment= new Comment();
        $formAddComment = $this->createForm('AppBundle\Form\CommentAddType', $newComment);
        $formAddComment->handleRequest($request);

        if ($formAddComment->isSubmitted() && $formAddComment->isValid() && $this->getUser()) {
            $visible = true;
            if($news->getCategory()->getName() == 'Politic'){
                $visible = false;
            }
            $comment = $formAddComment->getData();
            $comment->setUser($this->getUser())
                ->setNews($news)
                ->setDate(new \DateTime())
                ->setCountLike(0)
                ->setCountDislike(0)
                ->setVisible($visible);

            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'comment add');
//            return $this->redirectToRoute('news_show_one',['id'=> 108]);

        }

        return ['formAddComment' => $formAddComment->createView()];

    }

    /**
     * @param Request $request
//     * @Route("/comment-answer", name="comment_answer")
     * @Template()
     * @return array | Response
     */
    public function commentAnswerAction(Request $request)
    {
        $news = $this->getDoctrine()->getRepository('AppBundle:News')->find(108);
        $newComment = new Comment();
        $formAddCommentAnswer = $this->createForm('AppBundle\Form\CommentAddAnswerType',$newComment);
        $formAddCommentAnswer->handleRequest($request);
        $parentId = 512;
//        $id = $request->getUri();
//        dump($id);

        if ($formAddCommentAnswer->isSubmitted() && $formAddCommentAnswer->isValid()) {
            $visible = true;
//            if($news->getCategory()->getName() == 'Politic'){
//                $visible = false;
//            }

            $comment = $formAddCommentAnswer->getData();
            $comment->setUser($this->getUser())
                ->setParent($parentId)
                ->setNews($news)
                ->setDate(new \DateTime())
                ->setCountLike(0)
                ->setCountDislike(0)
                ->setVisible($visible)
            ;

            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'comment answer add');
//            return $this->redirectToRoute('news_show_one',['id'=> 75]);
        }
        return ['addAnswerComment' => $formAddCommentAnswer];
    }

    /**
     * @param Request $request
     * @Route("/comment/{id}-{rating}", name="comment_rating")
     * @return Response
     */
    public function ratingAction(Request $request)
    {

        $user = $this->getUser();
        if (!$user){
            return $this->redirectToRoute('login');
        }
        $comment_id = $request->get('id');
        $mark = $request->get('rating');
        $user_id = $user->getId();
        $comment = $this->getDoctrine()->getRepository('AppBundle:Comment')->find($comment_id);
        $rez = $this->getDoctrine()->getRepository('AppBundle:Rating')
            ->findBy(['commentId' => $comment_id, 'userId' => $user_id]);

        if ($rez){
            $chose = $rez[0];
            if ($rez[0]->getPick() != $mark){
                $chose->setPick($mark);
                $this->getDoctrine()->getManager()->persist($chose);
                if ($mark == 'l'){
                    $comment->setCountLike($comment->getCountLike()+1);
                    $comment->setCountDislike($comment->getCountDislike()-1);
                }elseif($mark == 'd'){
                    $comment->setCountLike($comment->getCountLike()-1);
                    $comment->setCountDislike($comment->getCountDislike()+1);
                }
            }
        }else{
            $chose = new Rating();
            $chose->setCommentId($comment_id)->setUserId($user_id)->setPick($mark);
            $this->getDoctrine()->getManager()->persist($chose);
            if ($mark == 'l'){
                $comment->setCountLike($comment->getCountLike()+1);
            }elseif($mark == 'd'){
                $comment->setCountDislike($comment->getCountDislike()+1);
            }
        }

        $this->getDoctrine()->getManager()->persist($chose);
        $this->getDoctrine()->getManager()->persist($comment);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('news_show_one',['id'=> $comment->getNews()->getId()]);
    }
}