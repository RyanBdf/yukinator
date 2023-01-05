<?php

namespace App;

use App\Entity\Flat;
use App\Repository\FlatRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class Game {
	public function __construct(
		public FlatRepository $flatRepository,
		public QuestionRepository $questionRepository,
		public readonly Session $session = new Session(),
	) {
	}

	public function get( string $key ): ?array {
		return $this->session->get( "game" )[ $key ];
	}

	public function start(): void {
			$this->session->start();
			$this->session->remove( "game" );
			$this->session->set( "game", [
				"flats"     => $this->flatRepository->findAll(),
				"questions" => $this->questionRepository->findBy([], ['id' => 'ASC']),
			] );
	}

	public function confirm( bool $answer ): void {
		$flats = $this->get( "flats" );

		if ( sizeof( $flats ) > 1 ) {
			foreach ( $flats as $key => $flat ) {
				foreach ( $flat->getAnswersQuestions() as $answerQuestion ) {
					if ( $this->get( 'questions' )[0] === $answerQuestion->getQuestion() && $answerQuestion->isAnswer() !== $answer ) {
						unset( $flats[ $key ] );
					}
				}
			}

			$questions = $this->get( 'questions' );
			unset( $questions[0] );

			$this->session->set( "game", [
				"flats"     => array_values($flats),
				"questions" => array_values($questions),
			] );
		}
	}

	public function end(): ?Flat {
		$flat = $this->get( 'flats' )[0];
		$this->session->remove( "game" );

		return $flat;
	}

}
