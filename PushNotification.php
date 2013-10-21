<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 10/18/13
 * Time: 2:53 PM
 * To change this template use File | Settings | File Templates.
 */
class PushNotification extends CApplicationComponent {

	/**
	 * @param string|null $apnsCertificateFilePath
	 * @param string|null $serviceUrl
	 *
	 * @return PNIosTransport
	 */
	public function createIosTransport($apnsCertificateFilePath = null, $serviceUrl = null) {
		$transport = new PNIosTransport($serviceUrl);
		if ($apnsCertificateFilePath) {
			$transport->setApnsCertificateFile($apnsCertificateFilePath);
		}
		return $transport;
	}

	/**
	 * @param string|null $message
	 *
	 * @return PNIosPayload
	 */
	public function createIosPayload($message = null) {
		return new PNIosPayload($message);
	}

	/**
	 * @param string|null $apiKey
	 * @param string|null $serviceUrl
	 *
	 * @return PNAndroidTransport
	 */
	public function createAndroidTransport($apiKey = null, $serviceUrl = null) {
		$transport = new PNAndroidTransport($serviceUrl);
		return $transport->setApiKey($apiKey);
	}

	/**
	 * @param string|null $message
	 *
	 * @return PNAndroidPayload
	 */
	public function createAndroidPayload($message = null) {
		return new PNAndroidPayload($message);
	}
}