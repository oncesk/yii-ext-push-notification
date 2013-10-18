<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 10/18/13
 * Time: 4:06 PM
 * To change this template use File | Settings | File Templates.
 */

class PushNotificationIosPayload extends APushNotificationPayload {

	/**
	 * @param string $message
	 *
	 * @return PushNotificationIosPayload
	 */
	public function setMessage($message) {
		if (is_string($message)) {
			$this->_payload['alert'] = $message;
		}
		return $this;
	}

	/**
	 * Sound key
	 *
	 * @param string $sound
	 *
	 * @return PushNotificationIosPayload
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