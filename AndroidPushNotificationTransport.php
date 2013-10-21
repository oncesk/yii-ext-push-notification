<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 10/18/13
 * Time: 3:17 PM
 * To change this template use File | Settings | File Templates.
 */

class AndroidPushNotificationTransport extends APushNotificationTransport {

	/**
	 * @var string
	 */
	protected $_apiKey;

	/**
	 * @var string
	 */
	protected $_serviceUrl;

	/**
	 * @param string $apiKey
	 * @param string $serviceUrl
	 */
	public function __construct($apiKey, $serviceUrl = 'https://android.googleapis.com/gcm/send') {
		$this->setServiceUrl($serviceUrl);
		$this->_apiKey = $apiKey;
	}

	/**
	 * @param PushNotificationAndroidPayload $payload
	 *
	 * @return mixed|void
	 * @throws CException
	 */
	public function send($payload) {
		if (!($payload instanceof PushNotificationAndroidPayload)) {
			throw new CException('Invalid payload: payload must implements from PushNotificationAndroidPayload');
		}

		$androidPayload = $payload->getPayload();
		if (is_array($androidPayload)) {
			foreach ($androidPayload as $p) {
				$this->_sendPackage($p);
			}
		} else {
			$this->_sendPackage($androidPayload);
		}
	}

	/**
	 * @param null $message
	 *
	 * @return PushNotificationAndroidPayload
	 */
	public function createPayload($message = null) {
		return new PushNotificationAndroidPayload($message);
	}


	protected function _sendPackage($payload) {
		$headers = array(
			'Authorization: key=' . $this->_apiKey,
			'Content-Type: application/json'
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->_serviceUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

		$result = curl_exec($ch);

		curl_close($ch);
	}
}