
DROP TABLE IF EXISTS img;
CREATE TABLE img (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    url varchar(300) NOT NULL,
    time int(11) NOT NULL,
    size int(11) NOT NULL,
    width int(11) NOT NULL,
    height int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
