<?php

function generate_ref(string $prefix)
{
    return $prefix . mt_rand(1000000, 999999999) . time();
}
