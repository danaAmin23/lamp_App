

DROP DATABASE IF EXISTS LAMP2PROJECT;
DROP USER IF EXISTS dana;
CREATE DATABASE LAMP2PROJECT;
USE LAMP2PROJECT;
ALTER DATABASE LAMP2PROJECT CHARACTER SET utf8 COLLATE utf8_general_ci;


CREATE USER 'dana'@'localhost' IDENTIFIED BY 'dana';

GRANT ALL PRIVILEGES ON LAMP2PROJECT.paths  TO 'dana'@'localhost';
GRANT ALL PRIVILEGES ON LAMP2PROJECT.pt_endpoints  TO 'dana'@'localhost';
GRANT ALL PRIVILEGES ON LAMP2PROJECT.pt_midpoints  TO 'dana'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE paths (
pt_id INT (11)  NOT NULL AUTO_INCREMENT ,
pt_name VARCHAR(100) NOT NULL,
pt_length FLOAT(4,2) NOT NULL,
pt_description VARCHAR(255 ) NOT NULL,
pt_note BLOB NULL,
PRIMARY KEY (pt_id) USING BTREE
);



CREATE TABLE pt_endpoints(
pt_id INT (11) NOT NULL AUTO_INCREMENT,
edpt_bgn_path_dist FLOAT (4,2) NOT NULL, 
edpt_bgn_ground_height FLOAT (4,2) NOT NULL,
edpt_bgn_antenna_height FLOAT (4,2) NOT NULL,
edpt_end_path_dist FLOAT(4,2) NOT NULL,
edpt_end_ground_height FLOAT (4,2) NOT NULL,
edpt_end_antenna_height FLOAT (4,2) NOT NULL,
PRIMARY KEY (pt_id) USING BTREE,
CONSTRAINT FK_PATH_ID FOREIGN KEY (pt_id) REFERENCES paths (pt_id)

);

CREATE TABLE pt_midpoints(
mdpt_id INT(11) AUTO_INCREMENT NOT NULL,
mdpt_bgn_path_dist FLOAT (4,2) NOT NULL,
mdpt_ground_height FLOAT (4,2) NOT NULL,
mdpt_terrain_type VARCHAR(50) NOT NULL,
obs_height FLOAT (4,2) NOT NULL,
obs_type VARCHAR(50) NOT NULL,
pt_id INT (11) NOT NULL,
PRIMARY KEY (mdpt_id) USING BTREE,
FOREIGN KEY (pt_id) REFERENCES paths(pt_id)
);




