<?php
class PNIosPayload extends APNPayload {

	/**
	 * @param string $message
	 *
	 * @return PNIosPayload
	 */
	public function setMessage($message) {
		if (is_string($message)) {
			$this->_payload['alert'] = $message;
		}
		return $this;
	}

	/**
	 * @param string|null $serviceUrl
	 *
	 * @return PNIosTransport
	 */
	public function createTransport($serviceUrl = null) {
		return new PNIosTransport($serviceUrl);
	}

	/**
	 * Sound key
	 *
	 * @param string $sound
	 *
	 * @return PNIosPayload
	 */
	public function setSound($sound) {
		if (is_string($sound)) {
			$this->_payload['sound'] = $sound;
		}
		return $this;
	}

	/**
	 * Initializing payload
	 */
	protected function init() {
		$this->_payload = array(
			'alert' => '',
			'sound' => 'default'
		);
	}
}