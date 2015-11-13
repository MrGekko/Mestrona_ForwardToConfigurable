<?php

/**
 * Mestrona magento module
 *
 * LICENSE
 *
 * This source file is subject of Mestrona.
 * You may be not allowed to change the sources
 * without authorization of Mestrona GbR.
 *
 * @copyright  Copyright (c) 2012 Mestrona GbR (http://www.mestrona.net)
 * @author Mestrona GbR <support@mestrona.net>
 * @category Mestrona
 * @package Mestrona_ForwardToConfigurable
 */
class Mestrona_ForwardToConfigurable_Block_Page_Html_Head extends Mage_Page_Block_Html_Head
{
    /**
     * Customize meta robots tags when viewing simple product.
     *
     * @return string
     */
    public function getRobots()
    {
        if (empty($this->_data['robots'])) {
            $this->_data['robots'] = Mage::getStoreConfig('design/head/default_robots');
        }

        if (($_product = Mage::registry('current_product')) && ($_productId = Mage::registry('current_product')->getId()) && ($_uriid = $this->getRequest()->getParam('id'))) {
            $parentIds = Mage::getModel('catalog/product_type_configurable')
                ->getParentIdsByChild($_uriid);
            if (!empty($parentIds) && in_array($_productId, $parentIds)) { // does not have a parent -> nothing to do
                $this->_data['robots'] = 'NOINDEX, NOFOLLOW';
            }
        }

        return $this->_data['robots'];
    }
}
