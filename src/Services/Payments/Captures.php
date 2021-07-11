<?php

namespace Drewdan\Paypal\Services\Payments;

use Drewdan\Paypal\Dtos\Capture;
use Drewdan\Paypal\Client\PaypalClient;

class Captures extends PaypalClient {

	/**
	 * Shows a capture from the capture ID
	 *
	 * @param string $captureId Paypal capture ID
	 * @return \Drewdan\Paypal\Dtos\Capture
	 * @throws \JsonMapper_Exception
	 */
	public function show(string $captureId): Capture {
		$capture = $this->client->get('payments/captures/' . $captureId)->object();

		return $this->mapper->map($capture, new Capture);
	}

	/**
	 * Refund a capture payment
	 *
	 * @param string $captureId Paypal capture ID
	 * @param float $amount float amount on original currency
	 * @param string $reason (optional) reason for the refund
	 * @param string $invoiceId (optional) invoice id
	 * @return \Drewdan\Paypal\Dtos\Capture
	 * @throws \JsonMapper_Exception
	 */
	public function refund(string $captureId, float $amount, string $reason = '', string $invoiceId = ''): Capture {
		$capture = $this->client->post('payments/captures/' . $captureId . '/refund', array_filter([
			'amount' => $amount,
			'note_to_payer' => $reason,
			'invoice_id' => $invoiceId,
		]))->object();

		return $this->mapper->map($capture, new Capture);
	}

}
