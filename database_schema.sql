CREATE TABLE `student`  (	
	`student_id`		INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
	`first_name`	    VARCHAR(50) NOT NULL,
	`surname`		    VARCHAR(20) NOT NULL,
	`address`		    VARCHAR(100) NOT NULL,
	`phone`		        VARCHAR(15) NOT NULL,
    `dob`               DATE NOT NULL,
    `email`             VARCHAR(80) NOT NULL,
    `subscribe`         INT(1) NOT NULL
); 

CREATE TABLE `tailored_class` (	
	`tailored_class_id`		INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`summary`	            VARCHAR(50) NOT NULL,
	`start_date`		    DATE NOT NULL,
	`end_date`		        DATE NOT NULL,
	`quote`		            DECIMAL(7,2) NOT NULL,
    `other_info`            VARCHAR(40) NOT NULL,
    `student_id`            INT(11) NOT NULL
); 

ALTER TABLE `tailored_class`
    ADD CONSTRAINT `student_tailored_class_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);


CREATE TABLE `category` (
    `category_id`         INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `category_name`       VARCHAR(50) NOT NULL
);

CREATE TABLE `course` (
    `course_id`         INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `course_name`       VARCHAR(50) NOT NULL,
    `course_price`      DECIMAL(7,2) NOT NULL,
    `category_id`       INT(11) NOT NULL
);

CREATE TABLE `course_image` (
    `course_image_id`       INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `course_id`             INT(11) NOT NULL,
    `file_path`             text NOT NULL
);


ALTER TABLE `course`
    ADD CONSTRAINT `course_category_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);


ALTER TABLE `course_image`
    ADD CONSTRAINT `course_image_fk` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE;


CREATE TABLE `users` (
     `username`       VARCHAR(64) NOT NULL PRIMARY KEY,
     `password`       VARCHAR(64) NOT NULL
);

INSERT INTO `student` (`student_id`, `first_name`, `surname`, `address`,`phone`, `dob`, `email`, `subscribe`)
VALUES (1, 'Doreen', 'McKernan', '85969 Pearson Terrace', '772-291-5803', '2011-07-26', 'dmckernan0@ask.com', 0),
       (2, 'Eba', 'Butchard', '669 Utah Place', '450-186-6443', '2012-08-18', 'ebutchard1@go.com', 1),
       (3, 'Tisha', 'Boswood', '7194 Troy Lane', '785-905-0701', '2008-08-27', 'tboswood2@google.es', 0),
       (4, 'Dar', 'Ferraron', '7909 Arizona Circle', '604-807-1513', '2007-10-02', 'dferraron3@ow.ly', 1),
       (5, 'Davis', 'Tesdale', '77762 North Street', '789-470-1391', '2008-01-10', 'dtesdale4@berkeley.edu', 0),
       (6, 'Kalil', 'Hawick', '1180 Service Parkway', '963-277-4270', '2009-12-03', 'khawick5@nba.com', 1),
       (7, 'Gianna', 'Asche', '492 Roth Way', '269-871-1033', '2009-07-14', 'gasche6@springer.com', 0),
       (8, 'Carlen', 'Shambrooke', '81 Iowa Drive', '877-801-5010', '2007-07-03', 'cshambrooke7@mozilla.com', 0),
       (9, 'Stanfield', 'Lorentzen', '378 Ramsey Court', '519-512-5916', '2007-05-09', 'slorentzen8@scribd.com', 1),
       (10, 'Wilfred', 'Rosenblatt', '64119 Laurel Hill', '708-223-0315', '2010-06-25', 'wrosenblatt9@tuttocitta.it', 0),
       (11, 'Zia', 'Ingerman', '73759 Manitowish Circle', '242-276-9812', '2008-08-04', 'zingermana@marketwatch.com', 0),
       (12, 'Lorettalorna', 'Tortis', '41657 Northland Crossing', '232-469-9193', '2010-08-17', 'ltortisb@woothemes.com', 0),
       (13, 'Riva', 'Lawrance', '74 American Trail', '658-610-3091', '2012-07-25', 'rlawrancec@devhub.com', 1),
       (14, 'Chlo', 'Schaumaker', '1112 Huxley Park', '916-322-0604', '2007-10-10', 'cschaumakerd@indiatimes.com', 1),
       (15, 'Elinor', 'Batchelar', '3 Grover Hill', '930-109-3179', '2010-06-25', 'ebatchelare@marriott.com', 0),
       (16, 'Bastien', 'Dursley', '2 Marcy Trail', '341-889-6182', '2013-08-23', 'bdursleyf@barnesandnoble.com', 1),
       (17, 'Rozella', 'Tuffrey', '57005 Kings Lane', '350-672-6188', '2010-08-24', 'rtuffreyg@yahoo.co.jp', 1),
       (18, 'Gabriell', 'Sarsons', '672 Corben Trail', '573-602-4785', '2013-02-08', 'gsarsonsh@squidoo.com', 0),
       (19, 'Dalton', 'Dorkin', '85 Waxwing Avenue', '299-265-3244', '2013-11-26', 'ddorkini@uiuc.edu', 0),
       (20, 'Rodolphe', 'Cancutt', '324 Lien Circle', '373-467-4076', '2013-11-23', 'rcancuttj@smh.com.au', 1);

INSERT INTO `tailored_class`(`tailored_class_id`, `summary`, `start_date`, `end_date`, `quote`, `other_info`, `student_id`)
VALUES (1, 'Private Guitar Lesson', '2019-09-17', '2019-11-23', 50, 'Level 2 Building B', 8),
       (2, 'Private Oboe Lesson', '2018-02-14', '2018-08-05', 55, 'Level 1 Building A', 14);

INSERT INTO `category` (`category_id`, `category_name`)
VALUES (1, 'Piano'),
       (2, 'Guitar'),
       (3, 'Violin'),
       (4, 'Oboe'),
       (5, 'Clarinet'),
       (6, 'Drum');

INSERT INTO `course` (`course_id`, `course_name`, `course_price`, `category_id`)
VALUES (1, 'Basic Piano', 25, 1),
       (2, 'Intermediate Piano', 30, 1),
       (3, 'Advanced Piano', 40, 1),
       (4, 'Basic Guitar', 26.5, 2),
       (5, 'Intermediate Guitar', 32, 2),
       (6, 'Advanced Guitar', 38, 2),
       (7, 'Basic Violin', 22.5, 3),
       (8, 'Intermediate Violin', 30, 3),
       (9, 'Advanced Violin', 35, 3),
       (10, 'Basic Oboe', 30, 4),
       (11, 'Intermediate Oboe', 44, 4),
       (12, 'Basic Clarinet', 28.5, 5),
       (13, 'Intermediate Clarinet', 42, 5),
       (14, 'Basic Drum', 23, 6),
       (15, 'Intermediate Drum', 27, 6),
       (16, 'Advanced Drum', 35, 6);

INSERT INTO `course_image` (`course_image_id`, `course_id`, `file_path`)
VALUES (1, 1, 'piano1.jpg'),
       (2, 2, 'piano2.jpg'),
       (3, 3, 'piano3.jpg'),
       (4, 4, 'guitar1.jpg'),
       (5, 5, 'guitar2.jpg'),
       (6, 6, 'guitar3.jpg'),
       (7, 7, 'violin1.jpg'),
       (8, 8, 'violin2.jpg'),
       (9, 9, 'violin3.jpg'),
       (10, 10, 'oboe1.jpg'),
       (11, 11, 'oboe2.jpg'),
       (12, 12, 'clarinet1.jpg'),
       (13, 13, 'clarinet2.jpg'),
       (14, 14, 'drum1.jpg'),
       (15, 15, 'drum2.jpg'),
       (16, 16, 'drum3.jpg');


-- Dane's username and password
INSERT INTO `users` (`username`, `password`)
VALUES ('daneadmin', SHA2('DaneTheDreamer54321', 0));