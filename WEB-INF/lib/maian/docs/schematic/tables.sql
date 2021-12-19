CREATE TABLE ms_settings (
  id             tinyint(1) NOT NULL auto_increment,
  path           text,
  total          int(3) NOT NULL default '25',
  language       varchar(30) NOT NULL default '',
  target         enum('0','1'),
  log            enum('0','1'),
  skipwords      text,
  htmlcode       text,
  PRIMARY KEY    (id)
) TYPE=MyISAM;

INSERT INTO ms_settings VALUES ('1', 'http://www.yoursite.com/search', '25', 'english.php', '1', '1', 'and,or,with,the,of,to,it,is,on,in,as,am,are,when,was,what,for,from,all,there,them,your,at', 'Settings Not Updated');

CREATE TABLE ms_pages(
  id             int(7) NOT NULL auto_increment,
  title          text,
  description    text,
  url            text,
  keywords       text,
  PRIMARY KEY    (id)
) TYPE=MyISAM;

CREATE TABLE ms_logfile(
  id int(7)      NOT NULL auto_increment,
  keywords       text,
  count          int(10) NOT NULL default '0',
  PRIMARY KEY    (id)
) TYPE=MyISAM;
