<?php

declare(strict_types=1);

namespace Salamek\Zasilkovna\Entity;

final class Carrier
{
	private int $id;

	private string $name;

	private string $labelRouting;
	
	/**
	 * @param mixed[] $data
	 */
	public function __construct(array $data)
	{
		$this->id = (int) $data['id'];
		$this->name = $data['name'];
		$this->labelRouting = $data['labelRouting'];
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getLabelRouting(): string
	{
		return $this->labelRouting;
	}
}
