<?php

spl_autoload_register(function ($fqcn) {
  $path = str_replace(['Api', '\\'], ['src', '/'], $fqcn) . '.php';
  require_once $path;
});
