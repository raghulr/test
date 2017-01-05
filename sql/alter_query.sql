ALTER TABLE 'restaurants'
	ADD COLUMN 'featured_image' VARCHAR(255) NULL AFTER 'thump',
	ADD COLUMN 'featured_number' INT(1) NULL AFTER 'featured_image';
