<?php

declare(strict_types=1);

namespace Salamek\Zasilkovna;

use Salamek\Zasilkovna\Model\IBranchStorage;

final class Carrier
{
	private string $jsonEndpoint;

	public function __construct(string $apiKey, IBranchStorage $branchStorage)
	{
		if (trim($apiKey) === '') {
			throw new \RuntimeException('API key can not be empty.');
		}
		$this->branchStorage = $branchStorage;
		$this->jsonEndpoint = 'https://www.zasilkovna.cz/api/v4/' . $apiKey . '/branch.json?address-delivery';
		$this->initializeStorage();
	}

	public function initializeStorage(bool $force = false): void
	{
		if ($force || !$this->branchStorage->isStorageValid()) {
			if (!($result = file_get_contents($this->jsonEndpoint))) {
				throw new \RuntimeException('Failed to open JSON endpoint');
			}
			if (!($data = \json_decode($result, true)) || !array_key_exists('data', $data)) {
				throw new \RuntimeException('Failed to decode JSON');
			}

			$this->branchStorage->setBranchList($data['carriers']);
		}
	}
	
	/**
	 * @return \Salamek\Zasilkovna\Entity\Carrier[]
	 */
	public function getList(): array
	{
		$entity = $this->getHydrateToEntity();
		$return = [];
		foreach ($this->branchStorage->getBranchList() as $branch) {
			$return[] = new $entity($branch);
		}

		return $return;
	}

	public function find(int $id): ?\Salamek\Zasilkovna\Entity\Carrier
	{
		if (($branch = $this->branchStorage->find($id)) === null) {
			return null;
		}

		$entity = $this->getHydrateToEntity();

		return new $entity($branch);
	}
	
	private function getHydrateToEntity(): string
	{
		return \Salamek\Zasilkovna\Entity\Carrier::class;
	}
}
