<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\ServiceController;
use AppBundle\Entity\Tag;
use AppBundle\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/admin",name="admin_index")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        return [];
    }


    /**
     * @Route("/admin/task",name="admin_test")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function taskAction(Request $request)
    {
        $tags = $this->getDoctrine()->getRepository('AppBundle:Tag')->getTag();

        $form = $this->createForm(TagType::class)
            ->add('add',SubmitType::class);
//            ->handleRequest($request);

        return ['tags'=> $tags, 'form' => $form->createView()];
    }

    /**
     * @Route("/admin/task/add/{id}",name="admin_test_add")
     * @param Request $request
     * @return JsonResponse
     */
    public function taskAddAction(Request $request)
    {
        $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->find($request->get('id'));
        if (!$tag){
            $data = "Tag not found in DB";
            $code = 404;
        }else{
//            $this->getDoctrine()->getManager()->remove($tag);
//            $this->getDoctrine()->getManager()->flush();
            $data = "Tag delete";
            $code = 200;
        }
        $response = new JsonResponse($data, $code);
        return $response;
//
    }

}
