CREATE DATABASE counter;

CREATE TABLE counter.request (
  id int(11) NOT NULL AUTO_INCREMENT,
  domain_id int(11) NOT NULL,
  url_id int(11) NOT NULL,
  element_id int(11) NOT NULL,
  count int(11) NOT NULL,
  time DATETIME,
  duration varchar(11),
  PRIMARY KEY (id)
);

CREATE TABLE counter.domain (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255),
  PRIMARY KEY (id)
);

CREATE TABLE counter.url (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255),
  PRIMARY KEY (id)
);

CREATE TABLE counter.element (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255),
  PRIMARY KEY (id)
);