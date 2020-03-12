CREATE TABLE `properties` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `description` text NOT NULL,
      `county` varchar(50) NOT NULL,
      `country` varchar(50) NOT NULL,
      `address` text,
      `image_full` varchar(256) DEFAULT NULL,
      `image_thumbnail` varchar(256) DEFAULT NULL,
      `latitude` varchar(256) DEFAULT NULL,
      `longitude` varchar(256) DEFAULT NULL,
      `num_bedrooms` int(3) NOT NULL,
      `num_bathrooms` int(3) NOT NULL,
      `price` decimal(10,2) NOT NULL,
      `property_type_id` int(11) NOT NULL,
      `type` varchar(256) NOT NULL,
      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `postcode` varchar(100) DEFAULT NULL,
      `uuid` varchar(256) NOT NULL,
      `town` varchar(100) NOT NULL,
      PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
