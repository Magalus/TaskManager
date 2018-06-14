<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Listing;
use AppBundle\Entity\Task;

class TaskeditController extends Controller {

	public function taskAction(Request $request) {

		$id = $request->query->get('id');

		// Récupération de la tâche à éditer

		$task = $this
			->getDoctrine()
			->getRepository(Task::class)
			->find($id);

		$list = $task->getListing();

		$list_id = $list->getId();

		// Création du formulaire

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
        	$entityManager->persist($task);
        	$entityManager->flush();

        	$this->addFlash("successedittask", "Tâche modifiée avec succès");

			return $this->redirectToRoute('taskdetail', ['id' => $list_id]);
		}

		return $this->render('taskeditlist/index.html.twig', [
				'form' => $form->createView()
		]);
	}

	public function listAction(Request $request) {

		$id = $request->query->get('id');

		// Récupération de la liste à éditer

		$list = $this
			->getDoctrine()
			->getRepository(Listing::class)
			->find($id);

		// Création du formulaire

		$formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $list);

		$formBuilder
			->add('name', TextType::class)
			->add('save', SubmitType::class);

		$form = $formBuilder->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$entityManager = $this->getDoctrine()->getManager();
        	$entityManager->persist($list);
        	$entityManager->flush();

			$this->addFlash("successeditlist", "Nom de la liste modifié avec succès");

			return $this->redirectToRoute('taskdetail', ['id' => $id]);
		}

		return $this->render('taskeditlist/index.html.twig', [
				'form' => $form->createView()
		]);
	}
}