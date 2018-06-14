<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Listing;
use AppBundle\Entity\Task;

class TasklistController extends Controller {

	public function indexAction(Request $request) {

		// Affichage des listes de tâches

		$listing = $this
			->getDoctrine()
			->getRepository(Listing::class)
			->findAll();

		$tasks = $this
			->getDoctrine()
			->getRepository(Task::class)
			->findAll();

		// Affichage du formulaire

		$list = new Listing();

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

        	$newlists = $this
        		->getDoctrine()
        		->getRepository(Listing::class)
        		->findBy([],[
        			'id' => 'desc'],1,0);

        	foreach($newlists as $newlist) {

        		$newlistid = $newlist->getId();
        	}

        	// Redirection vers la page détail de la liste créée

			return $this->redirectToRoute('taskdetail', ['id' => $newlistid]);
		}

		return $this->render('tasklist/index.html.twig', [
			'listing' => $listing,
			'tasks' => $tasks,
			'form' => $form->createView()
		]);
	}

	public function removeAction(Request $request) {

		// Suppression d'une liste de tâche

		$id = $request->query->get('id');

		$em = $this
			->getDoctrine()
			->getManager();

		$entity = $em->getRepository(Listing::class)->find($id);

		$em->remove($entity);
		$em->flush();

		$this->addFlash("success", "Liste supprimée avec succès");

		return $this->redirectToRoute('tasklist');
	}
}