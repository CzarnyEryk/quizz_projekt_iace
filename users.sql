create table users
(
    user_id    int auto_increment
        primary key,
    e_mail     text          not null,
    password   text          not null,
    name       text          not null,
    score      int default 0 not null,
    level      int default 0 not null,
    final_quiz int default 0 not null
);

INSERT INTO quizz.users (e_mail, password, name, score, level, final_quiz) VALUES ('arek@test.com', '7612af49c66b808e35e52ac425dab238a1bd9c9a9518275e95f3998074e2522a', 'Arkadiusz', 0, 0, 0);
INSERT INTO quizz.users (e_mail, password, name, score, level, final_quiz) VALUES ('adrian@test.com', 'c23ad6f18412014673b2d04794ca038ef6767fe94afe408dffb775362fe07e68', 'Adrian', 0, 0, 0);
INSERT INTO quizz.users (e_mail, password, name, score, level, final_quiz) VALUES ('andrzej@test.com', '56a17f2ad6a1aad9a8707a8c712772d1ceb4e491012148d2a0de0f8b764a7130', 'Andrzej', 0, 0, 0);
INSERT INTO quizz.users (e_mail, password, name, score, level, final_quiz) VALUES ('adam@test.com', 'f7f376a1fcd0d0e11a10ed1b6577c99784d3a6bbe669b1d13fae43eb64634f6e', 'Adam', 0, 0, 0);
