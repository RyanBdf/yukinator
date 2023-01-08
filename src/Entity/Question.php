<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity( repositoryClass: QuestionRepository::class )]
class Question {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column( length: 255 )]
	#[Assert\Length(
		min: 3
	)]
	private string $label;

	#[ORM\OneToMany( mappedBy: 'question', targetEntity: AnswersQuestion::class, cascade: ['persist'], fetch: "EAGER" )]
	private Collection $answersQuestions;

	public function __construct() {
		$this->answersQuestions = new ArrayCollection();
	}

	public function getLabel(): ?string {
		return $this->label;
	}

	public function setLabel( string $label ): self {
		$this->label = $label;

		return $this;
	}

	public function getAnswersQuestions(): Collection {
		return $this->answersQuestions;
	}

	public function addAnswersQuestion( AnswersQuestion $answersQuestion ): self {
		if ( ! $this->answersQuestions->contains( $answersQuestion ) ) {
			$this->answersQuestions->add( $answersQuestion );
			$answersQuestion->setQuestion( $this );
		}

		return $this;
	}

	public function removeAnswersQuestion( AnswersQuestion $answersQuestion ): self {
		if ( $this->answersQuestions->removeElement( $answersQuestion ) ) {
			// set the owning side to null (unless already changed)
			if ( $answersQuestion->getQuestion() === $this ) {
				$answersQuestion->setQuestion( null );
			}
		}

		return $this;
	}

	public function __toString(): string {
		return $this->label;
	}


}
