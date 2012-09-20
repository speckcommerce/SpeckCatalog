alter table `catalog_product`
add CONSTRAINT `fk_product_product_type_id`
    FOREIGN KEY (`product_type_id` )
    REFERENCES `catalog_product_type` (`product_type_id` )
    ON DELETE RESTRICT
    ON UPDATE RESTRICT;

alter table `catalog_product`
add CONSTRAINT `fk_product_manufacturer_company_id`
    FOREIGN KEY (`manufacturer_id` )
    REFERENCES `contact_company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

alter table `catalog_product_uom`
add CONSTRAINT `fk_catalog_product_uom_uom_code`
    FOREIGN KEY (`uom_code` )
    REFERENCES `ansi_uom` (`uom_code` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

alter table `catalog_product_uom`
add CONSTRAINT `fk_catalog_product_uom_product_id`
    FOREIGN KEY (`product_id` )
    REFERENCES `catalog_product` (`product_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_availability`
add CONSTRAINT `fk_catalog_availability_product_uom`
    FOREIGN KEY (`product_id` , `uom_code` , `quantity` )
    REFERENCES `catalog_product_uom` (`product_id` , `uom_code` , `quantity` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_availability`
add CONSTRAINT `fk_catalog_availability_distributor`
    FOREIGN KEY (`distributor_id` )
    REFERENCES `contact_company` (`company_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_category_website`
add CONSTRAINT `fk_catalog_category_linker_category_id`
    FOREIGN KEY (`category_id` )
    REFERENCES `catalog_category` (`category_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

alter table `catalog_category_website`
add CONSTRAINT `fk_catalog_category_linker_parent_category_id`
    FOREIGN KEY (`parent_category_id` )
    REFERENCES `catalog_category` (`category_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

alter table `catalog_category_website`
add CONSTRAINT `fk_catalog_category_linker_website_id`
    FOREIGN KEY (`website_id` )
    REFERENCES `website` (`website_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

alter table `catalog_category_product`
add CONSTRAINT `fk_catalog_product_category_linker_category_id`
    FOREIGN KEY (`category_id` )
    REFERENCES `catalog_category` (`category_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_category_product`
add CONSTRAINT `fk_catalog_product_category_linker_product_id`
    FOREIGN KEY (`product_id` )
    REFERENCES `catalog_product` (`product_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_category_product`
add CONSTRAINT `fk_catalog_product_category_linker_website_id`
    FOREIGN KEY (`website_id` )
    REFERENCES `website` (`website_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

alter table `catalog_choice`
add CONSTRAINT `fk_catalog_choice_product_id`
    FOREIGN KEY (`product_id` )
    REFERENCES `catalog_product` (`product_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_choice`
add CONSTRAINT `fk_catalog_choice_option_id`
    FOREIGN KEY (`option_id` )
    REFERENCES `catalog_option` (`option_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_choice_option`
add CONSTRAINT `fk_catalog_choice_option_linker_1`
    FOREIGN KEY (`option_id` )
    REFERENCES `catalog_option` (`option_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_choice_option`
add CONSTRAINT `fk_catalog_choice_option_linker_2`
    FOREIGN KEY (`choice_id` )
    REFERENCES `catalog_choice` (`choice_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_option_image`
add CONSTRAINT `fk_catalog_option_image_1`
    FOREIGN KEY (`option_id` )
    REFERENCES `catalog_option` (`option_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_product_document`
add CONSTRAINT `fk_catalog_product_document_1`
    FOREIGN KEY (`product_id` )
    REFERENCES `catalog_product` (`product_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_product_image`
add CONSTRAINT `fk_catalog_product_image_1`
    FOREIGN KEY (`product_id` )
    REFERENCES `catalog_product` (`product_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_product_option`
add CONSTRAINT `fk_catalog_product_option_linker_product_id`
    FOREIGN KEY (`product_id` )
    REFERENCES `catalog_product` (`product_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_product_option`
add CONSTRAINT `fk_catalog_product_option_linker_option_id`
    FOREIGN KEY (`option_id` )
    REFERENCES `catalog_option` (`option_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;

alter table `catalog_product_spec`
add CONSTRAINT `fk_catalog_product_spec_1`
    FOREIGN KEY (`product_id` )
    REFERENCES `catalog_product` (`product_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE;
