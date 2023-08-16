<?php

namespace App\Infrastructure\Http\Entity;

enum StatusCode: int
{
    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case BAD_REQUEST = 400;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case SERVER_UNAVAILABLE = 503;
}
