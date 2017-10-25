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
use AppBundle\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @Template()
     * @Route("/admin/comment", name = "admin_comment_index")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {

        $query = $this->getDoctrine()->getRepository('AppBundle:Comment')->findAll();
        $paginator  = $this->get('knp_paginator');
        dump($query);
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        $form = $this->createForm('AppBundle\Form\CommentEditType')
            ->add('save', SubmitType::class);

        return ['comments' => $pagination, 'form' => $form->createView()];
    }

    /**
     * @Route("/admin/comment-visible-{id}",name="admin_comment_visible")
     * @param Request $request
     * @return JsonResponse
     */
    public function visibleAction(Request $request)
    {
        $comment = $this->getDoctrine()->getRepository('AppBundle:Comment')->find($request->get('id'));
        if (!$comment){
            $data = "Comment not found in DB";
            $code = 404;
        }else{
            if($comment->getVisible()){
                $comment->setVisible(false);
                $this->getDoctrine()->getManager()->persist($comment);
                $this->getDoctrine()->getManager()->flush();
                $data = false;
                $code = 200;
            }else{
                $comment->setVisible(true);
                $this->getDoctrine()->getManager()->persist($comment);
                $this->getDoctrine()->getManager()->flush();
                $data = true;
                $code = 200;
            }
        }
        $response = new JsonResponse($data, $code);
        return $response;
//
    }



}