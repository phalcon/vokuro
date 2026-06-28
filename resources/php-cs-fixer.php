<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(
        [
            __DIR__ . '/../src',
            __DIR__ . '/../config',
            __DIR__ . '/migrations',
            __DIR__ . '/seeds',
            __DIR__ . '/../public',
            __DIR__ . '/../tests/Unit',
            __DIR__ . '/../tests/Functional',
        ]
    );

return (new PhpCsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRiskyAllowed(false)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/../tests/_output/.php-cs-fixer.cache')
    ->setRules(
        [
            'ordered_imports'        => [
                'sort_algorithm' => 'alpha',
                'imports_order'  => ['class', 'function', 'const'],
            ],
            'ordered_class_elements' => [
                'sort_algorithm' => 'alpha',
                'order'          => [
                    'use_trait',
                    'case',
                    'constant_public',
                    'constant_protected',
                    'constant_private',
                    'property_public_static',
                    'property_protected_static',
                    'property_private_static',
                    'property_public',
                    'property_protected',
                    'property_private',
                    'construct',
                    'destruct',
                    'magic',
                    'phpunit',
                    'method_public_static',
                    'method_protected_static',
                    'method_private_static',
                    'method_public',
                    'method_protected',
                    'method_private',
                ],
            ],
        ]
    )
    ->setFinder($finder);
