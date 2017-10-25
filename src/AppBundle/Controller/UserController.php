<?php
/**
 * Created by PhpStorm.
 * User: puzzle
 * Date: 01.08.17
 * Time: 19:53
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/user-page/{id}", name="user_index")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $id = $request->get('id');
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->findBy(['user' => $id, 'visible' => true],['countLike' =>'DESC', 'countDislike' => 'ASC']);
        return ['comments' => $comments];
    }

    /**
     * @Route("/my-page", name="user_my_page")
     * @Template()
     * @param Request $request
     * @return array | Response
     */
    public function myPageAction(Request $request)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('login');
        }
        $id = $this->getUser()->getId();
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->findBy(['user' => $id],['countLike' =>'DESC', 'countDislike' => 'ASC']);
        return ['comments' => $comments];
    }

}