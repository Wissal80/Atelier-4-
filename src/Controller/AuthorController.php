<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AuthorType;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    
    

#[Route('/Affiche', name: 'app_Affiche')]


public function Affiche (AuthorRepository $repository)
    {
        $author=$repository->findAll() ; 
        return $this->render('author/Affiche.html.twig',['author'=>$author]);
    }

    #[Route('/Add', name: 'app_Add')]

    public function  Add (Request  $request)
    {
        $author=new Author();
        $form =$this->CreateForm(AuthorType::class,$author);
      $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_Affiche');
        }
        return $this->render('author/Add.html.twig',['f'=>$form->createView()]);
    
    }

    #[Route('/edit/{id}', name: 'app_edit')]
    public function edit(AuthorRepository $repository, $id, Request $request)
    {
        $author = $repository->find($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->add('Edit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); 
            return $this->redirectToRoute("app_Affiche");
        }

        return $this->render('author/edit.html.twig', [
            'f' => $form->createView(),
        ]);
    }


    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete($id, AuthorRepository $repository)
    {
        $author = $repository->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();

        
        return $this->redirectToRoute('app_Affiche');
    }

#[Route('/AddStatistique', name: 'app_AddStatistique')]

    public function addStatistique(EntityManagerInterface $entityManager): Response
    {
        
        $author1 = new Author();
        $author1->setUsername("test"); 
        $author1->setEmail("test@gmail.com"); 
        $entityManager->persist($author1);
        $entityManager->flush();

        return $this->redirectToRoute('app_Affiche'); 
        
    }
}
