<?php

namespace Tekrow\Lvg\Lumen;

use Tekrow\Lvg\FileRepository;

class LumenFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }
}
