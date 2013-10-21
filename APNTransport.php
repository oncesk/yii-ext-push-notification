<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 10/18/13
 * Time: 3:06 PM
 * To change this template use File | Settings | File Templates.
 */
abstract class APNTransport {

	/**
	 * @var string
	 */
	protected $_serviceUrl;

	/**
	 * @param APNPayload $payload
	 *
	 * @return mixed
	 */
	abstract public function send($payload);

	/**
	 * @param null $message
	 *
	 * @return APNPayload
	 */
	abstract public function createPayload($message = null);

	/**
	 * @param string $serviceUrl
	 */
	public function __construct($serviceUrl) {
		$this->setServiceUrl($serviceUrl);
	}

	/**
	 * @param string $url
	 *
	 * @return APNTransport
	 */
	public function setServiceUrl($url) {
		if (is_string($url)) {
			$this->_serviceUrl = $url;
		}
		return $this;
	}
}