<?php

$ruleset = new TwigCsFixer\Ruleset\Ruleset();
$ruleset->addStandard(new TwigCsFixer\Standard\TwigCsFixer());
//$ruleset->removeSniff(TwigCsFixer\Sniff\EmptyLinesSniff::class);

$config = new TwigCsFixer\Config\Config();
$config->setRuleset($ruleset);
$config->setCacheFile(null);

return $config;
