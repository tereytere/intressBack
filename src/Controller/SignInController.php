<?php

namespace App\Controller;

use App\Entity\SignIn;
use App\Form\SignInType;
use App\Repository\SignInRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/signin')]
class SignInController extends AbstractController
{
    #[Route('/', name: 'signin_index', methods: ['GET'])]
    public function index(SignInRepository $signInRepository): Response
    {
        return $this->render('signin/index.html.twig', [
            'signin' => $signInRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'signin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SignInRepository $signInRepository): Response
    {
        $signIn = new SignIn();
        $form = $this->createForm(SignInType::class, $signIn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $signInRepository->save($signIn, true);

            return $this->redirectToRoute('signin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('signin/new.html.twig', [
            'signin' => $signIn,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'signin_show', methods: ['GET'])]
    public function show(SignIn $signIn): Response
    {
        return $this->render('signin/show.html.twig', [
            'signin' => $signIn,
        ]);
    }

    #[Route('/{id}/edit', name: 'signin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SignIn $signIn, SignInRepository $signInRepository): Response
    {
        $form = $this->createForm(SignInType::class, $signIn);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $signInRepository->save($signIn, true);

            return $this->redirectToRoute('signin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('signin/edit.html.twig', [
            'signin' => $signIn,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'signin_delete', methods: ['POST'])]
    public function delete(Request $request, SignIn $signIn, SignInRepository $signInRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signIn->getId(), $request->request->get('_token'))) {
            $signInRepository->remove($signIn, true);
        }

        return $this->redirectToRoute('signin_index', [], Response::HTTP_SEE_OTHER);
    }
}
