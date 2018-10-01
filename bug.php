<?php

require 'vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$file = __DIR__ . '/cache/container.php';
$containerBuilder = new ContainerBuilder();
$loader = new YamlFileLoader($containerBuilder, new FileLocator(__DIR__));
$loader->load('di.yaml');


$containerBuilder->compile();
$dumper = new \Symfony\Component\DependencyInjection\Dumper\PhpDumper($containerBuilder);
file_put_contents($file, $dumper->dump());


require_once $file;
$container = new ProjectServiceContainer();
$one = $container->get('service_one');
$two = $container->get('service_two');

if (!$two instanceof ArrayObject) {
    throw new UnexpectedValueException('Expect \ArrayObject service');
}

echo 'Success';
