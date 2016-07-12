<?php

namespace Tgallice\FBMessenger\Model\QuickReplies;

class Text implements \JsonSerializable
{
	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $payload;

	/**
	 * @param string $title
	 * @param string $payload
	 */
	public function __construct($title, $payload)
	{
		$this->title = $title;
		$this->payload = $payload;

		$this->validateElement();
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getPayload()
	{
		return $this->payload;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize()
	{
		return [
			'content_type' => 'text',
			'title' => $this->title,
			'payload' => $this->payload
		];
	}

	private function validateElement()
	{
		if (mb_strlen($this->title) > 20) {
			throw new \InvalidArgumentException('The "title" field should not exceed 20 characters');
		}

		if (!empty($this->payload) && mb_strlen($this->payload) > 1000) {
			throw new \InvalidArgumentException('The "payload" field should not exceed 1000 characters');
		}
	}
}