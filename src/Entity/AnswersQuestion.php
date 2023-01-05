<?php

namespace App\Entity;

use App\Repository\AnswersQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity( repositoryClass: AnswersQuestionRepository::class )]
class AnswersQuestion {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column]
	private ?bool $answer = null;

	#[ORM\ManyToOne( cascade: ['persist'], inversedBy: 'answersQuestions' )]
	#[ORM\JoinColumn( nullable: false )]
	private ?Question $question = null;

	#[ORM\ManyToOne( cascade: ['persist'], inversedBy: 'answersQuestions' )]
	#[ORM\JoinColumn( nullable: false )]
	private ?Flat $flat = null;

	public function getId(): ?int {
		return $this->id;
	}

	public function isAnswer(): ?bool {
		return $this->answer;
	}

	public function setAnswer( bool $answer ): self {
		$this->answer = $answer;

		return $this;
	}

	public function getQuestion(): ?Question {
		return $this->question;
	}

	public function setQuestion( ?Question $question ): self {
		$this->question = $question;

		return $this;
	}

	public function getFlat(): ?Flat {
		return $this->flat;
	}

	public function setFlat( ?Flat $flat ): self {
		$this->flat = $flat;

		return $this;
	}


}
