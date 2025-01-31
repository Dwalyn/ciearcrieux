<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__.'/src')
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PhpCsFixer' => true,
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        '@PHP81Migration' => true,
        'escape_implicit_backslashes' => false,
        'explicit_indirect_variable' => false,
        'string_implicit_backslashes' => false,
        'heredoc_to_nowdoc' => false,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
        'no_null_property_initialization' => false,
        'no_superfluous_elseif' => false,
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false,
        'phpdoc_add_missing_param_annotation' => false,
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_no_empty_return' => false,
        'phpdoc_order_by_value' => false,
        'return_assignment' => false,
        'simple_to_complex_string_variable' => false,
    ])
    ->setUsingCache(false)
    ->setFinder($finder);
