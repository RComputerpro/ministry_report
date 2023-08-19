<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserUpdateFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class UserUpdateController extends AbstractController
{
    #[Route('/compte', name: 'compte')]
    public function update(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, TokenStorageInterface $tsi): Response
    {
        $id = $tsi->getToken()->getUser();
        $user = $entityManager->getRepository(User::class)->find($id);
        $form = $this->createForm(UserUpdateFormType::class, $user);
        $form->handleRequest($request);

        $isSubmitted = false;

        if ($form->isSubmitted() && $form->isValid()) { 
            if($form->get('plainPassword')->getData() != null && !empty($form->get('plainPassword')->getData()))
            {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }
            $isSubmitted = true;
            
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user_update.html.twig', [
            'updateForm' => $form->createView(),
            'maj' => $isSubmitted
        ]);
    }
}
