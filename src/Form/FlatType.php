<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FlatType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ): void {
		$builder
			->add( 'flat', TextType::class, [
				"label"      => "Qu'est-ce que c'est du coup ?",
				"label_attr" => [
					"class" => "fw-bold",
				],
			] )
			->add( 'question', TextType::class, [
				"label"      => "Quelle question permet de le différencier de ",
				"label_attr" => [
					"class" => "fw-bold",
				],
			] )
			->add( 'answer', ChoiceType::class, [
				"label"      => "Quelle est la réponse ?",
				"label_attr" => [
					"class" => "fw-bold",
				],
				'choices'    => [
					'Oui' => true,
					'Non' => false,
				],
				'expanded'   => true,
			] )
			->add( "Enregistrer", SubmitType::class );
	}
}
