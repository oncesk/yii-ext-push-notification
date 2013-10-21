<?php
/**
 * Created by JetBrains PhpStorm.
 * User: once
 * Date: 10/18/13
 * Time: 4:01 PM
 * To change this template use File | Settings | File Templates.
 */
abstract class APNPayload {

	/**
	 * @var array
	 */
	protected $_payload = array();

	/**
	 * @var array
	 */
	protected $_recipientTokens = array();

	/**
	 * @var int
	 */
	protected $_tokenCount = 0;

	/**
	 * @param string $message
	 *
	 * @return APNPayload
	 */
	abstract public function setMessage($message);

	/**
	 * @param string|null $serviceUrl
	 *
	 * @return APNTransport
	 */
	abstract public function createTransport($serviceUrl = null);

	/**
	 * @param null                    $message
	 */
	public function __construct($message = null) {
		$this->init();
		if ($message) {
			$this->setMessage($message);
		}
	}

	/**
	 * @param string|array $token
	 *
	 * @return APNPayload
	 */
	public function setRecipientToken($token) {
		if (is_string($token) && is_numeric($token)) {
			if (!in_array($token, $this->_recipientTokens)) {
				$this->_recipientTokens[] = $token;
				$this->_tokenCount++;
			}
		} else if (is_array($token)) {
			foreach ($token as $t) {
				$this->setRecipientToken($t);
			}
		}
		return $this;
	}

	/**
	 * @return array
	 */
	public function getRecipientTokens() {
		return $this->_recipientTokens;
	}

	/**
	 * @return int
	 */
	public function getRecipientTokensCount() {
		return $this->_tokenCount;
	}

	/**
	 * @return string
	 */
	public function getPayload() {
		return json_encode($this->_payload);
	}

	/**
	 * @return array
	 */
	public function getRawPayload() {
		return $this->_payload;
	}

	/**
	 * Initialization
	 */
	protected function init() {}
}