
CREATE TABLE sayit_users (
	user_id SERIAL,
	email   VARCHAR(2000) NOT NULL,
	screen_name VARCHAR(20) NOT NULL,
	PRIMARY KEY(user_id)
);

CREATE TABLE sayit_messages (
	message_id SERIAL,
	user_id    INTEGER,
	ts         TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	topic      VARCHAR(100) DEFAULT '',
	message    VARCHAR(500) DEFAULT '',
	PRIMARY KEY(message_id),
	FOREIGN KEY (user_id) REFERENCES sayit_users(user_id) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO sayit_users VALUES (default, 'fred@fun.com', 'freddy');
INSERT INTO sayit_users VALUES (default, 'mary@fun.com', 'mary-meister');
INSERT INTO sayit_messages VALUES (default, 1,
	CURRENT_TIMESTAMP - interval '15 minutes', 'Cool Stuff', 'This is so super, duper cool!');
INSERT INTO sayit_messages VALUES (default, 2,
	CURRENT_TIMESTAMP - interval '11 minutes', 'Cool Stuff', 'Ice is really cold!');
INSERT INTO sayit_messages VALUES (default, 1,
	CURRENT_TIMESTAMP - interval '9 minutes', 'Cool Stuff', 'Frozen ice is also cold!');
INSERT INTO sayit_messages VALUES (default, 2,
	CURRENT_TIMESTAMP - interval '7 minutes', 'Fun Stuff', 'Watching TV is fun!');
INSERT INTO sayit_messages VALUES (default, 1,
	CURRENT_TIMESTAMP - interval '5 minutes', 'Fun Stuff', 'Watching a 72-inch TV is funner!');
INSERT INTO sayit_messages VALUES (default, 2,
	CURRENT_TIMESTAMP - interval '2 minutes', 'Fun Stuff', 'Watching a million-inch TV is funnest!');

CREATE VIEW get_all_messages AS
	SELECT message_id, user_id, email, screen_name, ts AT TIME ZONE 'America/Chicago' AS ts, topic, message
		FROM sayit_messages INNER JOIN sayit_users USING(user_id) ORDER BY ts DESC;

CREATE VIEW get_recent_messages AS
	SELECT message_id, user_id, email, screen_name, ts AT TIME ZONE 'America/Chicago' AS ts, topic, message
		FROM sayit_messages INNER JOIN sayit_users USING(user_id) ORDER BY ts DESC LIMIT 10;

CREATE VIEW get_topic_list AS
	SELECT topic, COUNT(topic) FROM sayit_messages GROUP BY topic ORDER BY COUNT(topic) DESC, topic;
