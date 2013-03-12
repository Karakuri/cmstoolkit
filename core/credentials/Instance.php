<?php

namespace core\credentials;

interface Instance {
	public function getIdentifier();
	public function getPayload();
}