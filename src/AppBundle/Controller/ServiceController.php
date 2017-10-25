<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ServiceController extends Controller
{
    /**
     * @Template()
     * @return array
     */
    public function indexAction($position = 'left')
    {
        $offset = 0;
        if ($position == 'right'){
            $offset = 4;
        }
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->findBy([],['id' => 'ASC'],4,$offset);

        return ['service' => $service];
    }
}
