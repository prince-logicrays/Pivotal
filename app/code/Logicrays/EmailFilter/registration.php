<?php
/**
 * Logicrays
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the logicrays.com license that is
 * available through the world-wide-web at this URL:
 * https://www.logicrays.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Logicrays Team
 * @package     Logicrays_EmailFilter
 * @copyright   Copyright (c) Logicrays (https://www.logicrays.com/)
 * @license     https://www.logicrays.com/LICENSE.txt
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Logicrays_EmailFilter',
    __DIR__
);
