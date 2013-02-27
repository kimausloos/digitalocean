<?php

namespace Thanatos\DigitalOceanBundle\Service;

/*
 * This file is part of the Thanatos DigitalOcean bundle.
 *
 * (c) Kim Ausloos <kim@thanatos.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Kim Ausloos <kim@thanatos.be>
 */

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

/**
 * This service allows you to make requests to the DigitalOcean api ( https://api.digitalocean.com/ )
 */
class DigitalOceanService
{
	/** 
	 * The userID from your DigitalOcean API Access settings
	 * 
	 * @var string
	 */
	private $userId;

	/** 
	 * The API key from your DigitalOcean API Access settings
	 *
	 * @var string
	 */
	private $apiKey;

	/** 
	 * The Guzzle HTTP client
	 *
	 * @var Guzzle\Http\Client 
	 */
	private $guzzleClient = null;


	/**
	 * Constructor with userId and apiKey. You can find these in your DigitalOcean API Access settings.
	 * 
	 * @param string $userId
	 * @param string $apiKey
	 */
	public function __construct($userId, $apiKey)
	{
		$this->userId 	= $userId;
		$this->apiKey 	= $apiKey;
	}


	/**
	 * Returns the Guzzle HTTP client 
	 * 
	 * @return Guzzle\Http\Client
	 */
	public function getClient()
	{
		if (null === $this->guzzleClient) {
			$this->guzzleClient = new Client('https://api.digitalocean.com/?client_id={clientid}&api_key={apikey}', array(
				'clientid' 	=> $this->userId,
				'apikey'	=> $this->apiKey,
			));
		}

		return $this->guzzleClient;
	}


	/**
	 * Get all droplets that are available
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function getDroplets()
	{
		try {
			$response = $this->getClient()->get('droplets')->send()->json();
		} catch (BadResponseException $e) {
			throw new \Exception("Error Processing Request");
		}

		if('ERROR' === $response['status']) {
			throw new \Exception("The api returned status ERROR: " . $response['description']);
		}

		return $response['droplets'];
	}


	/**
	 * Get info about a specific droplet
	 *
	 * @param string $dropletId
	 * @return array
	 * @throws \Exception
	 */
	public function getDroplet($dropletId)
	{
		try {
			$response = $this->getClient()->get('droplets/'.$dropletId)->send()->json();
		} catch (BadResponseException $e) {
			throw new \Exception("Error Processing Request");
		}
		
		if('ERROR' === $response['status']) {
			throw new \Exception("The api returned status ERROR: " . $response['description']);
		}

		return $response['droplet'];
	}


	/**
	 * Reboot a specific droplet
	 *
	 * @param string $dropletId
	 * @return bool
	 * @throws \Exception
	 */
	public function rebootDroplet($dropletId)
	{
		try {
			$response = $this->getClient()->get('droplets/'.$dropletId.'/reboot')->send()->json();
		} catch (BadResponseException $e) {
			throw new \Exception("Error Processing Request");
		}
		
		if('ERROR' === $response['status']) {
			throw new \Exception("The api returned status ERROR: " . $response['description']);
		}

		return ($response['status']=='OK')?true:false;
	}


	/**
	 * Powercyle a specific droplet
	 *
	 * @param string $dropletId
	 * @return bool
	 * @throws \Exception
	 */
	public function powercycleDroplet($dropletId)
	{
		try {
			$response = $this->getClient()->get('droplets/'.$dropletId.'/power_cycle')->send()->json();
		} catch (BadResponseException $e) {
			throw new \Exception("Error Processing Request");
		}
		
		if('ERROR' === $response['status']) {
			throw new \Exception("The api returned status ERROR: " . $response['description']);
		}

		return ($response['status']=='OK')?true:false;
	}


	/**
	 * Shutdown a specific droplet
	 *
	 * @param string $dropletId
	 * @return bool
	 * @throws \Exception
	 */
	public function shutdownDroplet($dropletId)
	{
		try {
			$response = $this->getClient()->get('droplets/'.$dropletId.'/shutdown')->send()->json();
		} catch (BadResponseException $e) {
			throw new \Exception("Error Processing Request");
		}

		if('ERROR' === $response['status']) {
			throw new \Exception("The api returned status ERROR: " . $response['description']);
		}
		
		return ($response['status']=='OK')?true:false;
	}


	/**
	 * Power a specific droplet off
	 *
	 * @param string $dropletId
	 * @return bool
	 * @throws \Exception
	 */
	public function poweroffDroplet($dropletId)
	{
		try {
			$response = $this->getClient()->get('droplets/'.$dropletId.'/power_off')->send()->json();
		} catch (BadResponseException $e) {
			throw new \Exception("Error Processing Request");
		}

		if('ERROR' === $response['status']) {
			throw new \Exception("The api returned status ERROR: " . $response['description']);
		}
		
		return ($response['status']=='OK')?true:false;
	}


	/**
	 * Power a specific droplet on
	 *
	 * @param string $dropletId
	 * @return bool
	 * @throws \Exception
	 */
	public function poweronDroplet($dropletId)
	{
		try {
			$response = $this->getClient()->get('droplets/'.$dropletId.'/power_on')->send()->json();
		} catch (BadResponseException $e) {
			throw new \Exception("Error Processing Request");
		}

		if('ERROR' === $response['status']) {
			throw new \Exception("The api returned status ERROR: " . $response['description']);
		}
		
		return ($response['status']=='OK')?true:false;
	}


	/**
	 * Destroy a specific droplet, this can not be undone!
	 *
	 * @param string $dropletId
	 * @return bool
	 * @throws \Exception
	 */
	public function destroyDroplet($dropletId)
	{
		try {
			$response = $this->getClient()->get('droplets/'.$dropletId.'/destroy')->send()->json();
		} catch (BadResponseException $e) {
			throw new \Exception("Error Processing Request");
		}

		if('ERROR' === $response['status']) {
			throw new \Exception("The api returned status ERROR: " . $response['description']);
		}
		
		return ($response['status']=='OK')?true:false;
	}

}