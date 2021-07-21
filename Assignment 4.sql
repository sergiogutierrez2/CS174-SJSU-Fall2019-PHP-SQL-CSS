CREATE TABLE video_cont3(
camera_id bigint(50) unsigned primary key auto_increment,
date_stamp timestamp NOT NULL, #this data type doesnt require size.
video_content varchar(100) NOT NULL, #100 should be good enough
thumb_image varchar(100) NOT NULL,
hash_video VARCHAR(256) NOT NULL
);

CREATE TABLE image_vids3 (
hash_video VARCHAR(256) NOT NULL,
date_stamp TIMESTAMP NOT NULL,
image_content varchar(200) NOT NULL,
timestamp_video TIMESTAMP NOT NULL
);