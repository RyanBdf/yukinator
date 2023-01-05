<?php

namespace App\Entity;

use App\Repository\FlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity( repositoryClass: FlatRepository::class )]
class Flat {

	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column( type: types::INTEGER )]
	private ?int $id = null;

	#[ORM\Column( type: Types::STRING, length: 20 )]
	private string $name;

	#[ORM\OneToMany( mappedBy: 'flat', targetEntity: AnswersQuestion::class, cascade: [ 'persist' ], fetch: "EAGER" )]
	private Collection $answersQuestions;

	public function __construct() {
		$this->answersQuestions = new ArrayCollection();
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName( string $name ): self {
		$this->name = $name;

		return $this;
	}

	public function getAnswersQuestions(): Collection {
		return $this->answersQuestions;
	}

	public function addAnswersQuestion( AnswersQuestion $answersQuestion ): self {
		if ( ! $this->answersQuestions->contains( $answersQuestion ) ) {
			$this->answersQuestions->add( $answersQuestion );
			$answersQuestion->setFlat( $this );
		}

		return $this;
	}

	public function removeAnswersQuestion( AnswersQuestion $answersQuestion ): self {
		if ( $this->answersQuestions->removeElement( $answersQuestion ) ) {
			// set the owning side to null (unless already changed)
			if ( $answersQuestion->getFlat() === $this ) {
				$answersQuestion->setFlat( null );
			}
		}

		return $this;
	}

	public function __toString(): string {
		return $this->name;
	}


}
