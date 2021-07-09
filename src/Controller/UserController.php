<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserAdminType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    private $security;
    private $passwordHasher;

    public function __construct(Security $security, UserPasswordHasherInterface $passwordHasher)
    {
        $this->security = $security;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //Récupération deu mot de passe
            $plainPassword = $user->getPassword();
            //Encodage du dit mot de passe
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $plainPassword
            ));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, $id, UserRepository $userRepository): Response
    {
        //Récupération du mail de l'utilisateur connecté (UserIdentifier)
        $userIdentifierConnected = $this->security->getUser()->getUserIdentifier();
        //Récupération du User connecté grace à son mail
        $userConnected = $userRepository->findOneBy(['email' => $userIdentifierConnected]);
        $userId = $userConnected->getId();
        
        //Accès à la page edit spécial Admin
        if ($this->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(UserAdminType::class, $user);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
    
                return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
            }
        
            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }
        //Accès à la page edit pour User simple
        elseif (($userId == $id)) {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
    
                return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
            }
        
            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
                'id' => $id
            ]);
        }

        return $this->redirectToRoute('user_edit', ['id' => $userId]);

    }

    /**
     * @Route("/{id}/edit/password", name="user_edit_password", methods={"GET","POST"})
     */
    public function editPassword(Request $request, User $user, $id, UserRepository $userRepository): Response
    {
        //Récupération du mail de l'utilisateur connecté (UserIdentifier)
        $userIdentifierConnected = $this->security->getUser()->getUserIdentifier();
        //Récupération du User connecté grace à son mail
        $userConnected = $userRepository->findOneBy(['email' => $userIdentifierConnected]);
        $userId = $userConnected->getId();

        if (($userId == $id) || ($this->isGranted('ROLE_ADMIN'))) {
        
            if ((isset($_POST['password']) && isset($_POST['passwordConfirm'])) && ($_POST['password'] === $_POST['passwordConfirm'])) {
                $entityManager = $this->getDoctrine()->getManager();
                $user = $entityManager->getRepository(User::class)->find($id);
                $newPassword = $_POST['password'];
                $user->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    $newPassword
                ));
                $entityManager->flush();
            } elseif (isset($_POST['password']) && isset($_POST['passwordConfirm'])) {
                $this->addFlash(
                    'warning',
                    'Les deux mot de passe ne correspondent pas'
                );
            }
            return $this->render('user/editPassword.html.twig',[
                
            ]);
        }
        return $this->redirectToRoute('user_edit_password', ['id' => $userId]);
    }
    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
