<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Listing;
use AppBundle\Entity\Task;

class TaskdetailController extends Controller {

	public function indexAction(Request $request) {

		$id = $request->query->get('id');
			
		// Affichage des tâches correspondant à la liste séléctionnée

		$listing = $this
			->getDoctrine()
			->getRepository(Listing::class)
			->find($id);

		if (empty($listing)) {

			return new Response('Aucune liste ne correspond à vos recherches !');
		}

		$tasks = $this
			->getDoctrine()
			->getRepository(Task::class)
			->findBy(['listing' => $listing]);

		return $this->render('taskdetail/index.html.twig', [
				'listing' => $listing,
				'tasks' => $tasks
		]);
	}

	public function statusAction(Request $request) {

		$id = $request->query->get('id');

		// Changement d'état de la tâche au clique sur le bouton changer d'état

		$task = $this
			->getDoctrine()
			->getRepository(Task::class)
			->find($id);

		$list = $task->getListing();

		$list_id = $list->getId();

		$status = $task->getStatus();

		if ($status == 'Done') {

			$task->setStatus('To do');
		}
		else {

			$task->setStatus('Done');
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($task);
		$em->flush();

		return $this->redirectToRoute('taskdetail', ['id' => $list_id]);
	}

	public function removeAction(Request $request) {

		$id = $request->query->get('id');

		// Suppression des tâches déjà effectuées

		$tasks = $this
			->getDoctrine()
			->getRepository(Task::class)
			->findBy(['listing' => $id]);

		foreach($tasks as $task) {

			$status = $task->getStatus();

			if ($status == 'Done') {

				$em = $this
					->getDoctrine()
					->getManager();

				$em->remove($task);
				$em->flush();
			}
		}

		$this->addFlash("successremove", "Tâches effectuées supprimées avec succès");

		return $this->redirectToRoute('taskdetail', ['id' => $id]);
	}
}