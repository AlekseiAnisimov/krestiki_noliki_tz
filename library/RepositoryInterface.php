<?php

interface RepositoryInterface
{
    public function init();

    public function read();

    public function write(Array $field);
}