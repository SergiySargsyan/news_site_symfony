<?php

namespace AppBundle\Controller;

use AppBundle\Controller\ServiceController;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Template()
     * @Route("/test",name="test")
     * @param Request $request
     * @return array
     */
    public function testAction(Request $request)
    {
        return[];
    }
}
