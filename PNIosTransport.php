<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 10/18/13
 * Time: 3:08 PM
 * To change this template use File | Settings | File Templates.
 */
class PNIosTransport extends APNTransport {

	/**
	 * @var bool
	 */
	protected $_autoClose = true;

	/**
	 * @var resource
	 */
	protected $_streamContext;

	/**
	 * @var resource
	 */
	protected $_socket;

	/**
	 * Path to ios certificate
	 *
	 * @var string
	 */
	protected $_apnsCertificateFilePath;

	/**
	 * @param string $serviceUrl
	 *
	 * @throws CException
	 */
	public function __construct($serviceUrl = 'ssl://gateway.push.apple.com:2195') {
		if ($serviceUrl) {
			parent::__construct($serviceUrl);
		}
	}

	/**
	 * @param string $apnsCertificateFile path to certificate file
	 *
	 * @return PNIosTransport
	 * @throws CException
	 */
	public function setApnsCertificateFile($apnsCertificateFile) {
		if (!$apnsCertificateFile || !file_exists($apnsCertificateFile)) {
			throw new CException('Ios certificate file \'' . $apnsCertificateFile . '\' does not exists');
		}
		$this->_apnsCertificateFilePath = $apnsCertificateFile;
		return $this;
	}

	/**
	 * If set to false socket don't destroyed after send else
	 * socket and context will be destroyed
	 *
	 * @param boolean|integer $autoClose
	 */
	public function setAutoClose($autoClose) {
		if (is_bool($autoClose) || is_int($autoClose)) {
			$this->_autoClose = $autoClose;
		}
	}

	/**
	 * @param PNIosPayload $payload
	 *
	 * @return mixed|void
	 * @throws CException
	 */
	public function send($payload) {
		if (!($payload instanceof APNPayload)) {
			throw new CException('Invalid payload: payload must implements from PNIosPayload');
		}

		$this
			->_createContext()
			->_createClientSocket();

		$iosPayload = $payload->getPayload();
		foreach ($payload->getRecipientTokens() as $token) {
			$this->_sendPackage($this->_createPackage($token, $iosPayload));
		}

		if ($this->_autoClose) {
			$this->close();
		}
	}

	/**
	 * @param null $message
	 *
	 * @return PNIosPayload
	 */
	public function createPayload($message = null) {
		return new PNIosPayload($message);
	}


	/**
	 * Close connection
	 */
	public function close() {
		if (is_resource($this->_streamContext)) {
			fclose($this->_streamContext);
		}
		if (is_resource($this->_socket)) {
			fclose($this->_socket);
		}
	}

	/**
	 * Create stream context and set context options like certificate file
	 *
	 * @return PNIosTransport
	 */
	protected function _createContext() {
		if (is_resource($this->_streamContext)) {
			return $this;
		}
		$this->_streamContext = stream_context_create();
		stream_context_set_option($this->_streamContext, 'ssl', 'local_cert', $this->_apnsCertificateFilePath);
		return $this;
	}

	/**
	 * Create socket client
	 *
	 * @return PNIosTransport
	 *
	 * @throws CException
	 */
	protected function _createClientSocket() {
		if (is_resource($this->_socket)) {
			return $this;
		}
		$error = $errorString = null;
		$this->_socket = stream_socket_client($this->_serviceUrl, $error, $errorString, 10, STREAM_CLIENT_CONNECT, $this->_streamContext);
		if (!$this->_socket) {
			throw new CException("Connection to " . $this->_serviceUrl . ' error: ' . $error . ", error_message: " . $errorString);
		}
		return $this;
	}

	/**
	 * @param string $token
	 * @param string $payload
	 *
	 * @return string
	 */
	protected function _createPackage($token, $payload) {
		return chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $token)) . chr(0) . chr(strlen($payload)) . $payload;
	}

	/**
	 * @param string $package
	 */
	protected function _sendPackage($package) {
		if (is_resource($this->_socket)) {
			fwrite($this->_socket, $package);
		}
	}
}