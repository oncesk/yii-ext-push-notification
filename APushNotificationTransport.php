<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 10/18/13
 * Time: 3:06 PM
 * To change this template use File | Settings | File Templates.
 */
abstract class APushNotificationTransport {

	/**
	 * @var string
	 */
	protected $_serviceUrl;

	/**
	 * @param APushNotificationPayload $payload
	 *
	 * @return mixed
	 */
	abstract public function send($payload);

	/**
	 * @param null $message
	 *
	 * @return APushNotificationPayload
	 */
	abstract public function createPayload($message = null);

	/**
	 * @param string $url
	 *
	 * @return APushNotificationTransport
	 */
	public function setServiceUrl($url) {
		if (is_string($url)) {
			$this->_serviceUrl = $url;
		}
		return $this;
	}
}