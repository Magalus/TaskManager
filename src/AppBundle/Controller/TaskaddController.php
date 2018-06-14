<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Listing;
use AppBundle\Entity\Task;

class TaskaddController extends Controller {

	public function indexAction(Request $request) {

		$id = $request->query->get('id');

		$list = $this
			->getDoctrine()
			->getRepository(Listing::class)
			->find($id);

		// Création du formulaire

		$task = new Task();

		$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $task);

		$choices = [
			'Fait' => 'Done',
			'A faire' => 'To do'
		];

		$formBuilder
			->add('title', TextType::class)
			->add('status', ChoiceType::class, [
				'choices' => $choices,
				'expanded' => false
			])
			->add('save', SubmitType::class);

		$form = $formBuilder->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$entityManager = $this->getDoctrine()->getManager();
			$task->setListing($list);
        	$entityManager->persist($task);
        	$entityManager->flush();

			$this->addFlash("successaddtask", "Tâche ajoutée avec succès");

			return $this->redirectToRoute('taskdetail', ['id' => $id]);
		}

		return $this->render('taskadd/index.html.twig', [
			'form' => $form->createview()
		]);
	}
}