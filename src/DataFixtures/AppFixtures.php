<?php

namespace App\DataFixtures;

use App\Entity\Flat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture {
	public function load( ObjectManager $manager ): void {
		$product = ( new Flat() )->setName( 'Une pizza' );
		$manager->persist( $product );
		$manager->flush();
	}
}
