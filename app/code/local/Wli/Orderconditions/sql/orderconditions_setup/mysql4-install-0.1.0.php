<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("
 
DROP TABLE IF EXISTS {$this->getTable('orderconditions')};
CREATE TABLE {$this->getTable('orderconditions')} (
  `orderconditions_id` int(11) NOT NULL AUTO_INCREMENT,
  `tags_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `condition_type_id` int(11) NOT NULL,
  `order_sub_total` float(8,2) DEFAULT NULL,
  `order_grand_total` float(8,2) DEFAULT NULL,
  `order_status_id` varchar(255) DEFAULT NULL,
  `billing_country_id` varchar(50),
  `shipping_country_id` varchar(50),
  `created_at` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `status` TINYINT( 2 ) NOT NULL DEFAULT  '0',
  PRIMARY KEY (`orderconditions_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 ;");
 
$installer->endSetup();

