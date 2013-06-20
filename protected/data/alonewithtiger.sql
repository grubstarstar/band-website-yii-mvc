CREATE TABLE song (
  id INT(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(100) DEFAULT NULL,
  art_url VARCHAR(100) DEFAULT NULL,
  bpm INT(11) DEFAULT NULL,
  file_name VARCHAR(128) NOT NULL,
  waveform_image VARCHAR(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;