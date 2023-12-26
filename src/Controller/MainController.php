<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Turbo\TurboBundle;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {

        $authForm = $this->createFormBuilder()
            ->add('username')
            ->add('pass')
            ->add('Submit', SubmitType::class)
            ->getForm();

        $authForm->handleRequest($request);

        $content = "This will be replaced";
        if ($authForm->isSubmitted() && $authForm->isValid()) {

            $content = "Replaced!";
            $authForm->addError(new FormError('ERR'));

            if (TurboBundle::STREAM_FORMAT == $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                return $this->render('index/index.stream.html.twig',
                    [
                        'content' => $content,
                        'form' => $authForm
                    ]);
            }

        }

        return $this->render('index/index.html.twig', [
            'authForm' => $authForm,
            'content' => $content
        ]);
    }
}
