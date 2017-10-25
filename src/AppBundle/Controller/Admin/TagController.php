<?php
/**
 * Created by PhpStorm.
 * User: puzzle
 * Date: 21.08.17
 * Time: 3:30
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Category;
use AppBundle\Entity\Tag;
use AppBundle\Form\CategoryType;
use AppBundle\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    /**
     * @Template()
     * @Route("/admin/tag", name = "admin_tag_index")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $tags = $this->getDoctrine()->getRepository('AppBundle:Tag')->getTag();

        $form = $this->createForm(TagType::class)
            ->add('add',SubmitType::class);
//            ->handleRequest($request);

        return ['tags'=> $tags, 'form' => $form->createView()];
    }



    /**
     * @Route("/admin/tag/create", name = "admin_tag_create")
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $name = ($request->get('appbundle_tag'))['name'];
        $id = ($request->get('appbundle_tag'))['id'];
        if ($name == ''){
            $data = "form not valid";
            $code = 404;
            $response = new JsonResponse($data, $code);
            return $response;
        }


        if ($id){
            $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->find($id);
            if (!$tag){
                $data = "Tag not found in DB";
                $code = 404;
            }else{
                $tag->setName($name);
                $this->getDoctrine()->getManager()->persist($tag);
                $data = "Tag edit";
                $code = 200;
            }
        }else{
            $tag = new Tag();
            $tag->setName($name);
            $this->getDoctrine()->getManager()->persist($tag);
            $data = "Tag create";
            $code = 200;
        }
        $this->getDoctrine()->getManager()->flush();
        $response = new JsonResponse($data, $code);
        return $response;

    }

    /**
     * @Route("/admin/tag/delete-{id}", name="admin_tag_delete")
     * @param Request $request
     * @return JsonResponse
     */

    public function deleteAction(Request $request)
    {
        $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->find($request->get('id'));
        if (!$tag){
            $data = "Tag not found in DB";
            $code = 404;
        }else{
            $this->getDoctrine()->getManager()->remove($tag);
            $this->getDoctrine()->getManager()->flush();
            $data = "Tag delete";
            $code = 200;
        }
        $response = new JsonResponse($data, $code);
        return $response;
    }

}