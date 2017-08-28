CREATE DATABASE counter;

CREATE TABLE request (
  id int(11) NOT NULL AUTO_INCREMENT,
  domain_id int(11) NOT NULL,
  url_id int(11) NOT NULL,
  element_id int(11) NOT NULL,
  count int(11) NOT NULL,
  time DATETIME,
  duration varchar(11),
  PRIMARY KEY (id)
);

CREATE TABLE domain (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255),
  PRIMARY KEY (id)
);

CREATE TABLE url (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255),
  PRIMARY KEY (id)
);

CREATE TABLE element (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255),
  PRIMARY KEY (id)
);