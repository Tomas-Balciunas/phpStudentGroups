<?php

namespace NFQ;

class Request
{
    public static function uri()
    {
        return str_replace("/nfq", "", trim($_SERVER['REQUEST_URI']));
    }
}
