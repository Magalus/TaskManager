<?php 

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Listing;
use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TaskmanagerFixtures extends Fixture 
{
    public function load(ObjectManager $manager) 
    {
        
        // Fixture pour la liste de tâche 'création site perso'

        $list1 = new Listing();
        $list1->setName('Création site perso');

        $manager->persist($list1);

       	$tab = [
       		['title' => 'Faire de la veille', 'status' => 'Done'],
       		['title' => 'Réaliser les maquettes', 'status' => 'To do'],
       		['title' => 'Intégration des maquettes', 'status' => 'To do'],
       		['title' => 'Développer la partie contact', 'status' => 'To do'],
       		['title' => 'Test du site', 'status' => 'To do']
       	];

       	foreach($tab as $row) {

       		$task = new Task();
       		$task->setTitle($row['title']);
       		$task->setStatus($row['status']);

       		$task->setListing($list1);
       		$manager->persist($task);
       	}

       	// Fixture pour la liste de tâche 'Voyage à Lisbonne'

       	$list2 = new Listing();
        $list2->setName('Voyage à Lisbonne');

        $manager->persist($list2);

       	$tab = [
       		['title' => 'Chercher un airbnb', 'status' => 'Done'],
       		['title' => 'Chercher des activités', 'status' => 'To do'],
       		['title' => 'Prendre les billets d\'avion', 'status' => 'Done'],
       		['title' => 'Trouver des souvenirs', 'status' => 'To do']
       	];

       	foreach($tab as $row) {

       		$task = new Task();
       		$task->setTitle($row['title']);
       		$task->setStatus($row['status']);

       		$task->setListing($list2);
       		$manager->persist($task);
       	}

       	// Fixture pour la liste de tâche 'Formations'

       	$list3 = new Listing();
        $list3->setname('Formations');

        $manager->persist($list3);

       	$tab = [
       		['title' => 'Symfony', 'status' => 'Done'],
       		['title' => 'Java', 'status' => 'To do'],
       		['title' => 'html/css', 'status' => 'Done'],
       		['title' => 'php', 'status' => 'Done'],
       		['title' => 'Javascript', 'status' => 'Done']
       	];

       	foreach($tab as $row) {

       		$task = new Task();
       		$task->setTitle($row['title']);
       		$task->setStatus($row['status']);

       		$task->setListing($list3);
       		$manager->persist($task);
       	}

       	// Fixture pour la liste de tâche 'Déménagement'

       	$list4 = new Listing();
        $list4->setname('Déménagement');

        $manager->persist($list4);

       	$tab = [
       		['title' => 'Faire les cartons', 'status' => 'Done'],
       		['title' => 'Louer un camion', 'status' => 'Done'],
       		['title' => 'Trouver de l\'aide', 'status' => 'To do'],
       		['title' => 'Nettoyer l\'appartement', 'status' => 'To do'],
       		['title' => 'Ranger dans le nouvel appartement', 'status' => 'To do']
       	];

       	foreach($tab as $row) {

       		$task = new Task();
       		$task->setTitle($row['title']);
       		$task->setStatus($row['status']);

       		$task->setListing($list4);
       		$manager->persist($task);
       	}

       	// Fixture pour la liste de tâche 'Entrainement marathon'

       	$list5 = new Listing();
        $list5->setname('Entrainement marathon');

        $manager->persist($list5);

       	$tab = [
       		['title' => 'Planning d\'entrainement', 'status' => 'Done'],
       		['title' => 'Planning nutritionnel', 'status' => 'Done'],
       		['title' => 'Courir', 'status' => 'Done'],
       		['title' => 'Acheter sa place', 'status' => 'To do']
       	];

       	foreach($tab as $row) {

       		$task = new Task();
       		$task->setTitle($row['title']);
       		$task->setStatus($row['status']);

       		$task->setListing($list5);
       		$manager->persist($task);
       	}

        $manager->flush();
    }
}