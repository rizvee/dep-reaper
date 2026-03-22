<?php

namespace DepReaper\Engine\OutputFormatter;

interface FormatterInterface
{
    public function format(array $result): void;
}
