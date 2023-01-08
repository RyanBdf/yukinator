<?php

namespace App\Tests;

use App\Entity\AnswersQuestion;
use App\Entity\Flat;
use App\Entity\Question;
use App\Repository\FlatRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityTest extends KernelTestCase {

	public function testCountFlat() {
		self::bootKernel();
		$flats = static::getContainer()->get( FlatRepository::class )->count( [] );
		$this->assertEquals( 1, $flats );
	}

	public function hasErrors( mixed $entity, int $count ) {
		self::bootKernel();
		$errors = self::getContainer()->get( 'validator' )->validate( $entity );
		$this->assertCount( $count, $errors );
	}

	public function getEntity(): AnswersQuestion {
		return ( new AnswersQuestion() )
			->setFlat( ( new Flat() )
				->setName( "Une pizza" ) )
			->setQuestion( ( new Question() )
				->setLabel( "Est-ce Froid ?" ) )
			->setAnswer( true );
	}

	public function testInvalidEntityQuestion() {
		$this->hasErrors( ( $this->getEntity() )->setQuestion( ( new Question() )->setLabel( "h" ) )->getQuestion(), 1 );
	}

	public function testValidEntity() {
		$this->hasErrors( $this->getEntity(), 0 );
	}


}
