<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magefan\CronSchedule\Block\Adminhtml\System\Config\Form;

class Info extends \Magefan\Community\Block\Adminhtml\System\Config\Form\Info
{
    /**
     * Return extension url
     *
     * @return string
     */
    protected function getModuleUrl(): string
    {
        return 'https://mage' .
            'fan.com/magento2-extensions?utm_source=cronschedule_config&utm_medium=link&utm_campaign=regular';
    }

    /**
     * Return extension title
     *
     * @return string
     */
    protected function getModuleTitle(): string
    {
        return 'Cron Schedule';
    }
}
