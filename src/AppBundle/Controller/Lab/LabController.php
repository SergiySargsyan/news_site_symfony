<?php

namespace AppBundle\Controller\Lab;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class LabController extends Controller
{

//    /**
//     * @param Request $request
//     * @Template()
//     * @Route("/lab1", name="lab1")
//     * @return array | Response
//     */
//    public function labOneAction(Request $request)
//    {
//
//        $form = $this->createFormBuilder()->add('System', ChoiceType::class,
//                [
//                    'choices' => ['TEXT' => 'TEXT', 'ASCII' => 'ASCII' ],
//                    'expanded' =>true,
//                    'data' => 'TEXT',
////                    'multiple' =>true,
//                ])
//            ->add('Action', ChoiceType::class,
//                [
//                    'choices' => ['code' => 'code', 'decode' => 'decode'],
//                    'expanded' =>true,
//                    'data' =>  'code'
////                    'multiple' =>true,
//                ])
//            ->add('text', TextType::class)
//            ->add('key', TextType::class)
//            ->add('submit', SubmitType::class)
//            ->getForm();
//
//        $form->handleRequest($request);
//        if ($form->isValid() && $form->isSubmitted())
//        {
//            $data = $form->getData();
//
//            if ($data['Action'] =='code'){
//                $rez = $this->code($data);
//                $this->addFlash('success', 'code ' . $rez);
//            }else{
//                $dec =$this->decode($data);
//                $this->addFlash('success', 'decode' . $dec);
//            }
//
////            die();
////            $dec =$this->decode($data);
////            $this->addFlash('success', 'decode' . $dec);
//            return $this->redirectToRoute('lab1');
//
//        }
//
//        return['form' => $form->createView()];
//    }
//
//
//    public function code($data)
//    {
//        $text = $data['text'];
//        $key = $data['key'];
//        $system = $data['System'];
//
//        $arrText = str_split($text);
//        foreach ($arrText as $value){
//            $t[] = ord($value);
//        }
////        dump($t);
//        $arrKey = str_split($key);
//        foreach ($arrKey as $value){
//            $k[] = ord($value);
//        }
//        foreach ($t as $key=>$value){
//            $rez[] = $value + $k[$key%count($k)];
//        }
//        foreach ($rez as $value){
//            $r[] = chr($value);
//        }
//        dump($rez);
//
//        return implode('',$r);
//    }
//
//    public function decode($data)
//    {
//        $text = $data['text'];
//        $key = $data['key'];
//        $system = $data['System'];
//        $arrText = str_split($text);
//        foreach ($arrText as $value){
//            $t[] = ord($value);
//        }
//        dump($t);
//        $arrKey = str_split($key);
//        foreach ($arrKey as $value){
//            $k[] = ord($value);
//        }
//        dump($k);
//
//        foreach ($t as $key=>$value){
//            $rez[] = $value - $k[$key%count($k)];
//        }
//        dump($rez);
//
//        foreach ($rez as $value){
//            $r[] = chr($value);
//        }
//
//        dump(implode('',$r));
//        return implode('',$r);
//    }
}