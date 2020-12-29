<?php

declare(strict_types=1);

namespace Salamek\Zasilkovna\Entity;


interface IBranch
{
	public function getName(): string;

	public function getLabelRouting(): string;

	public function getLatitude(): float;

	public function getLongitude(): float;

	public function getDistanceFrom(float $latitude, float $longitude): float;
}
