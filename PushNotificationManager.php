<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 10/18/13
 * Time: 2:53 PM
 * To change this template use File | Settings | File Templates.
 */
class PushNotificationManager extends CApplicationComponent {

	public function init() {
		parent::init();
	}

	/**
	 * @param string      $apnsCertificateFilePath
	 * @param string|null $serviceUrl
	 *
	 * @return IosPushNotificationTransport
	 */
	public function createIosTransport($apnsCertificateFilePath, $serviceUrl = null) {
		return new IosPushNotificationTransport($apnsCertificateFilePath, $serviceUrl);
	}

	/**
	 * @param string|null $message
	 *
	 * @return PushNotificationIosPayload
	 */
	public function createIosPayload($message = null) {
		return new PushNotificationIosPayload($this, $message);
	}

	/**
	 * @param string      $apiKey
	 * @param string|null $serviceUrl
	 *
	 * @return AndroidPushNotificationTransport
	 */
	public function createAndroidTransport($apiKey, $serviceUrl = null) {
		return new AndroidPushNotificationTransport($apiKey, $serviceUrl);
	}

	/**
	 * @param string|null $message
	 *
	 * @return PushNotificationAndroidPayload
	 */
	public function createAndroidPayload($message = null) {
		return new PushNotificationAndroidPayload($this, $message);
	}
}