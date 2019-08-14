<?php
/**
 * Woopra plugin for Magento 
 *
 * @category    design_default
 * @package     Jira_Woopra
 * @author      Jisse Reitsma (Jira ICT)
 * @copyright   Copyright (c) 2009 Jira ICT (http://www.jira.nl/)
 * @license     Open Software License
 */

class Jira_Woopra_Block_Script extends Mage_Core_Block_Template
{
    /*
     * Constructor method
     */
    public function _construct()
    {
        parent::_construct();

        // Decide whether the Woopra Plugin has been actived
        $website_id = Mage::helper('woopra')->getWebsiteId();
        if(Mage::helper('woopra')->enabled() == true && !empty($website_id)) {
            // Setting the template-name will generate the block
            $this->setTemplate('woopra/script.phtml');
        }
    }

    /*
     * Helper method to get data to show in Woopra
     */
    public function getSetting($key = '')
    {
        static $data;
        if(empty($data)) {

            $data = array(
                'website_id' => Mage::helper('woopra')->getWebsiteId(), // Woopra website ID
                'enabled' => Mage::helper('woopra')->enabled(), // Plugin status
                'test' => Mage::helper('woopra')->test(), // Plugin testing mode
            );

            $customer = Mage::getSingleton('customer/session')->getCustomer();
            if(!empty($customer)) {
                $data['name'] = Mage::getSingleton('customer/session')->getCustomer()->getName();
                $data['email'] = Mage::getSingleton('customer/session')->getCustomer()->getEmail();
                $data['avatar'] = '';

                $address = $customer->getDefaultBillingAddress();
                if(!empty($address)) $address = $customer->getDefaultShippingAddress();
                if(!empty($address)) {
                    $data['company'] = $address->getCompany();
                    $data['city'] = $address->getCity() . ' (' . $address->getCountryId() . ')';
                }
            }
        }

        if(isset($data[$key])) {
            return $data[$key];
        } else {
            return null;
        }
    }
}
