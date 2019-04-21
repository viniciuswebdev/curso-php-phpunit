<?php

namespace MyFramework\Controller;

class Response {

    const NOT_FOUND = 404;
    const OK = 200;
    const BAD_REQUEST = 400;
    const PRECONDITIONS_FAIL = 412;

    public function __construct($statusCode, $description = "") {

    }

}