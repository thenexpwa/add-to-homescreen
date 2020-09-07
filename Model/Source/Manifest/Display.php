<?php
/**
 * @package     add-to-homescreen
 * @author      NexPWA <hello@nexpwa.com>
 * @license     https://opensource.org/licenses/OSL-3.0 Open Software License v. 3.0 (OSL-3.0)
 * @link        http://www.nexpwa.com/
 * @copyright   Copyright © 2020 Codilar Technologies Pvt. Ltd.. All rights reserved
 */

namespace NexPWA\AddToHomescreen\Model\Source\Manifest;


use Magento\Framework\Data\OptionSourceInterface;

class Display implements OptionSourceInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $data = [];
        foreach ($this->toArray() as $value => $label) {
            $data[] = [
                'label' => $label,
                'value' => $value
            ];
        }
        return $data;
    }

    public function toArray()
    {
        return [
            'fullscreen' => __('Fullscreen'),
            'standalone' => __('Standalone'),
            'minimal-ui' => __('Minimal UI'),
            'browser' => __('Browser')
        ];
    }
}