<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 10/18/13
 * Time: 4:02 PM
 * To change this template use File | Settings | File Templates.
 */

class PushNotificationAndroidPayload extends APushNotificationPayload {

	/**
	 * @param string $message
	 *
	 * @return PushNotificationAndroidPayload
	 */
	public function setMessage($message) {
		if (is_string($message)) {
			$this->_payload['data']['message'] = $message;
		}
		return $this;
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