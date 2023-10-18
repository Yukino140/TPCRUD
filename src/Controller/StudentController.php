<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/Student")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/student", name="app_student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    /**
     * @Route("/st",name="app-st")
     */
    public function fetch(StudentRepository $rep):Response
    {
        $result=$rep->findAll();
        return $this->render('student/fetch.html.twig',[
            'res'=>$result
        ]);
    }

    /**
     * @Route("/add",name="add")
     */
    public function add(ManagerRegistry $mr):Response
    {
        $s=new Student();
        
    
        $s->setName("man");
        $s->setAge(18);
        $s->setEmail("mohamedomarfitouri@gmail.com");
        

        $em=$mr->getManager();
        $em->persist($s);
        $em->flush();
        return $this->redirectToRoute("app-st");
    } /**
    * @Route("/addf",name="addf")
    */
   public function addf(ManagerRegistry $mr,Request $req):Response
   {
      $s=new Student(); 
      $form=$this->createForm(StudentType::class);
      $form->handleRequest($req);
      if($form->isSubmitted()){
        $s = $form->getData();
       $em=$mr->getManager();
       $em->persist($s);
       $em->flush();
       return $this->redirectToRoute('app-st');
    }
       return $this->render("student/add.html.twig",[
        "f"=>$form->createView()
       ]);
   }
    /**
     * @Route("/rmv/{id}",name="rmv")
     */
    public function remove(ManagerRegistry $mr,StudentRepository $rep,$id):Response
    {
        $s=$rep->find($id);
        $em=$mr->getManager();
        $em->remove($s);
        $em->flush();
        return $this->redirectToRoute("app-st");
        
    }

    /**
     * @Route("/update/{id}", name="upd")
     */
    public function update(ManagerRegistry $mr,StudentRepository $rep,$id, Request $req):Response
    {
        $s=$rep->find($id); 
        $form=$this->createForm(StudentType::class,$s);
        $form->handleRequest($req);
        if($form->isSubmitted()){
          
         $em=$mr->getManager();
        
         $em->flush();
         return $this->redirectToRoute('app-st');
      }   
      return $this->render("student/update.html.twig",[
        "f"=>$form->createView()
       ]);
    }
}
