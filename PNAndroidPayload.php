<?php
class PNAndroidPayload extends APNPayload {

	/**
	 * @param string $message
	 *
	 * @return PNAndroidPayload
	 */
	public function setMessage($message) {
		if (is_string($message)) {
			$this->_payload['data']['message'] = $message;
		}
		return $this;
	}

	/**
	 * @param string|null $serviceUrl
	 *
	 * @return PNAndroidTransport
	 */
	public function createTransport($serviceUrl = null) {
		return new PNAndroidTransport($serviceUrl);
	}

	/**
	 * IF tokens more than 999 method will return array of payload strings
	 * else string
	 *
	 * @return string|array
	 */
	public function getPayload() {
		if ($this->getRecipientTokensCount() > 999) {
			$payload = array();
			$iterationCount = ceil($this->getRecipientTokensCount() / 999);
			$i = 0;
			while ($i < $iterationCount) {
				$this->_payload['registration_ids'] = array_slice($this->_recipientTokens, $i * 999, 999);
				$payload[] = parent::getPayload();
				$i++;
			}
			return $payload;
		} else {
			$this->_payload['registration_ids'] = $this->getRecipientTokens();
			return parent::getPayload();
		}
	}

	/**
	 * Init empty payload
	 */
	protected function init() {
		$this->_payload = array(
			'registration_ids' => array(),
			'data' => array()
		);
	}
}