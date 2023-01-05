<?php

namespace App\Controller;

use App\Entity\AnswersQuestion;
use App\Entity\Flat;
use App\Entity\Question;
use App\Form\FlatType;
use App\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController {

	public function __construct(
		public readonly Game $game
	) {
	}

	#[Route( '/', name: 'game.start' )]
	public function index(): Response {
		$this->game->start();
		if ( sizeof( $this->game->get( "flats" ) ) > 1 ) {
			return $this->redirectToRoute( "game.question" );
		} else {
			return $this->redirectToRoute( "game.found" );
		}
	}

	#[Route( '/question', name: 'game.question' )]
	public function question( Request $request ): Response {
		if ( $request->getMethod() === Request::METHOD_POST ) {
			if ( sizeof( $this->game->get( 'questions' ) ) > 1 ) {
				$this->game->confirm( $request->get( 'answer' ) === "Oui" );
			} else {
				return $this->redirectToRoute( 'game.found' );
			}
		}

		return $this->render( 'game/question.twig' );
	}

	#[Route( '/success', name: 'game.success' )]
	public function success(): Response {
		$flat = $this->game->end();

		return $this->render( 'game/success.twig', [
			"flat"     => $flat,
			"question" => "test",
		] );
	}

	#[Route( '/addFlat', name: 'game.add' )]
	public function addFlat( Request $request, EntityManagerInterface $em ): Response {
		$form = $this->createForm( FlatType::class );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() ) {
			$data = (object) $form->getData();

			$flat = ( new AnswersQuestion() )
				->setFlat( ( new Flat() )
					->setName( $data->flat ) )
				->setQuestion( ( new Question() )
					->setLabel( $data->question ) )
				->setAnswer( $data->answer );

			$em->persist( $flat );
			$em->flush();

			return $this->redirectToRoute( "game.confirm" );
		}

		return $this->render( 'game/add.twig', [
			'form' => $form->createView(),
		] );
	}

	#[Route( '/found', name: 'game.found' )]
	public function found(): Response {
		return $this->render( 'game/found.twig' );
	}

	#[Route( '/confirm', name: 'game.confirm' )]
	public function confirm(): Response {
		return $this->render( 'game/confirm.twig' );
	}


}
