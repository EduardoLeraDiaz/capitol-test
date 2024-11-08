<?php

namespace App\Common\Infrastructure\HTTP;

use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractHTTPController extends AbstractController
{
    public function __construct(readonly CommandBus $commandBus)
    {
    }
}