<?php

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        '@Symfony:risky' => true,
        '@PHP71Migration:risky' => true,
        '@PHP73Migration' => true,
        'blank_line_after_opening_tag' => true,
    ])
    ->setFinder(PhpCsFixer\Finder::create()
        ->exclude([
            'storage',
            'vendor',
        ])
        ->in(__DIR__)
    );
