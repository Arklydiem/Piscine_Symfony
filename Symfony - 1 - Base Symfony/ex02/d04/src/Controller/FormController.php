<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

class FormController extends AbstractController
{
    #[Route('/e02', name: 'first_form')]
    public function firstForm(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('message', TextType::class, [
                'constraints' => new NotBlank([
                    'message' => 'Message cannot be blank',
                ]),
                'label' => 'Message',
            ])
            ->add('include_timestamp', ChoiceType::class, [
                'choices' => [
                    'Yes' => 'yes',
                    'No' => 'no',
                ],
                'label' => 'Include timestamp',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Submit'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = $data['message'];
            $includeTimestamp = $data['include_timestamp'] === 'yes';

            $filePath = $this->getParameter('message_file_path');

            $content = $includeTimestamp ? $message . ' - ' . date('Y-m-d H:i:s') : $message;

            file_put_contents($filePath, $content . PHP_EOL, FILE_APPEND);

            $lastLine = $content;

            return $this->render('form/form.html.twig', [
                'form' => $form->createView(),
                'last_line' => $lastLine,
            ]);
        }

        return $this->render('form/form.html.twig', [
            'form' => $form->createView(),
            'last_line' => null,
        ]);
    }
}
