<?php

declare (strict_types=1);
namespace RectorPrefix202206;

use Rector\CakePHP\Set\CakePHPLevelSetList;
use Rector\CakePHP\Set\CakePHPSetList;
use Rector\Config\RectorConfig;
return static function (RectorConfig $rectorConfig) : void {
    $rectorConfig->sets([CakePHPSetList::CAKEPHP_44, CakePHPLevelSetList::UP_TO_CAKEPHP_43]);
};
