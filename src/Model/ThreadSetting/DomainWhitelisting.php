<?php

namespace Tgallice\FBMessenger\Model\ThreadSetting;

use Tgallice\FBMessenger\Model\ThreadSetting;

class DomainWhitelisting implements ThreadSetting, \JsonSerializable
{
	const TYPE_ADD = 'add';
	const TYPE_REMOVE = 'remove';
	
	const WHITELISTED_DOMAINS = 'whitelisted_domains';
	const DOMAIN_ACTION_TYPE = 'domain_action_type';
	
	/**
	 * @var string
	 */
	private $action;
	
	/**
	 * @var array
	 */
	private $domains = [];
	
	/**
	 * 
	 * @param string $action
	 * @param array $domains
	 * 
	 * @throws \InvalidArgumentException
	 */
	public function __construct($domains, $action = DomainWhitelisting::TYPE_ADD)
	{
		self::validateAction($action);
		self::validateDomains($domains);
		
		$this->action = $action;
		$this->domains = $domains;
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getDomains()
	{
		return $this->domains;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getAction()
	{
		return $this->action;
	}
	
	/**
	 * 
	 * @param string $action
	 * 
	 * @throws \InvalidArgumentException
	 */
	public static function validateAction($action)
	{
		if(!in_array($action, [DomainWhitelisting::TYPE_ADD, DomainWhitelisting::TYPE_REMOVE])) {
			throw new \InvalidArgumentException('The action must be type: "add" or "remove".');
		}
	}
	
	/**
	 * 
	 * @param array $domains
	 * 
	 * @throws \InvalidArgumentException
	 */
	public static function validateDomains($domains)
	{
		if(!is_array($domains)) {
			throw new \InvalidArgumentException('Domains must be a array.');
		}
		
		//https://developers.facebook.com/docs/messenger-platform/thread-settings/domain-whitelisting
		foreach($domains as $domain) {
			if(!preg_match('#^https:\/\/#', $domain)) {
				throw new \InvalidArgumentException('Each domain must be a "https" protocol.');
			}
		}
	}
	
	/**
	 * @inheritdoc
	 */
	public function jsonSerialize()
	{
		return [
			DomainWhitelisting::WHITELISTED_DOMAINS => $this->domains,
			DomainWhitelisting::DOMAIN_ACTION_TYPE => $this->action
		];
	}
}

