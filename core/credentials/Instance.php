<?php

namespace core\credentials;

interface Instance {
	abstract function getIdentifier();
	abstract function getPayload();
}