<?php

declare(strict_types=1);

namespace VeeWee\Xml\Reader\Matcher;

use Closure;
use VeeWee\Xml\Reader\Node\NodeSequence;

/**
 * @deprecated Use element_name instead! This will be removed in next major version
 * @return Closure(NodeSequence): bool
 */
function node_name(string $name): Closure
{
    return static function (NodeSequence $sequence) use ($name): bool {
        return $sequence->current()->name() === $name;
    };
}
