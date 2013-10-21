<?php
class PNAndroidTransport extends APNTransport {

	/**
	 * @var string
	 */
	protected $_apiKey;

	/**
	 * @var string
	 */
	protected $_serviceUrl;

	/**
	 * @param string $serviceUrl
	 */
	public function __construct($serviceUrl = 'https://android.googleapis.com/gcm/send') {
		if ($serviceUrl) {
			parent::__construct($serviceUrl);
		}
	}

	/**
	 * @param string $apiKey
	 *
	 * @return PNAndroidTransport
	 */
	public function setApiKey($apiKey) {
		if (is_string($apiKey)) {
			$this->_apiKey = $apiKey;
		}
		return $this;
	}

	/**
	 * @param PNAndroidPayload $payload
	 *
	 * @return mixed|void
	 * @throws CException
	 */
	public function send($payload) {
		if (!($payload instanceof PNAndroidPayload)) {
			throw new CException('Invalid payload: payload must implements from PNAndroidPayload');
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
	 * @return PNAndroidPayload
	 */
	public function createPayload($message = null) {
		return new PNAndroidPayload($message);
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