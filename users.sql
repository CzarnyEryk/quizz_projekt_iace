create table users
(
    user_id     int auto_increment
        primary key,
    e_mail      text                     not null,
    password    text                     not null,
    name        text                     not null,
    score       int  default 0           not null,
    level       int  default 0           not null,
    final_quiz  int  default 0           not null,
    surname     text                     not null,
    is_admin    int  default 0           null,
    departament text default 'Pracownik' null
);

INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (1, 'arek@test.com', '7612af49c66b808e35e52ac425dab238a1bd9c9a9518275e95f3998074e2522a', 'Arkadiusz', 10, 3, 10, 'Czerkies', 0, 'IT');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (7, 'admin@test.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'Admin', 0, 0, 0, 'Admin1', 1, 'Administrator');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (8, 'user1@example.com', '3f0c9b03e8e39b03773c7ea7621035cb6fc947cd41ca7c44056d7e7bbaebb3d4', 'Adam', 10, 2, 10, 'Kowalski', 0, 'Kadry');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (9, 'user2@example.com', 'b9522a06086ae83032bb8e1a9ad0fe3ec352b678fa4ef2ee20333a58752fe14f', 'Ewa', 5, 3, 5, 'Nowak', 0, 'Księgowość');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (10, 'user3@example.com', '5c5db120cb11bee138ff3143edcbedaead684de7a0ba140e12287d436c5dc487', 'Jan', 4, 1, 4, 'Wiśniewski', 0, 'Zarząd');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (11, 'user4@example.com', 'bf4fccd616251b678c56b9cb7a46819b1266853c180637642f5bc7d6b01f5554', 'Anna', 2, 3, 2, 'Zielińska', 0, 'Handlowy');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (12, 'user5@example.com', 'db3c2fe22a27e5ecd8e7fac83c5a961dba2bf8381745ccc6fb7a8d76c42ddafc', 'Tomasz', 10, 1, 10, 'Kamiński', 0, 'Produkcja');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (13, 'user6@example.com', '6aedc2c383a7057c949a36c02e42cf39da2f058763122dc3b50ab0f3eae49a78', 'Katarzyna', 9, 3, 9, 'Lewandowska', 0, 'Utrzymanie Czystości');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (14, 'user7@example.com', 'd235cf6d68634124ed023ecdd000624a9bc24a21112f1314dda9d4f2774fcba5', 'Michał', 3, 2, 3, 'Szymański', 0, 'IT');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (15, 'user8@example.com', 'a3f432225e05fbef891299d8bcb652d38fc281cab62520e5930c31b99133176b', 'Joanna', 1, 3, 1, 'Dąbrowska', 0, 'Kadry');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (16, 'user9@example.com', '0d9b61149a96de193d1eb08b99f3ebb9a9c1cf8c12d019180a2cc8f5c31887a0', 'Paweł', 5, 1, 5, 'Wójcik', 0, 'Księgowość');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (17, 'user10@example.com', '6bf0e3e9bcc66af85aff876fea65023e38846d847d5afb5f9f6aa62912e7daf2', 'Agnieszka', 8, 3, 8, 'Kwiatkowska', 0, 'Zarząd');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (18, 'user11@example.com', '923818e5629f40f9417e101c111f341dfe2956e5388284dd85ccf6f8e42951df', 'Piotr', 2, 3, 2, 'Woźniak', 0, 'Handlowy');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (19, 'user12@example.com', 'c14d56be84c26be2d2022b1e55b9294dbd68f04ab6ddc41b2c615c4d94e764f1', 'Marta', 6, 2, 6, 'Mazur', 0, 'Produkcja');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (20, 'user13@example.com', '3db724083230dd7154447b157cf17997a2bd0d0f5e4f6dc76b0e1e02dbf28c73', 'Krzysztof', 10, 2, 10, 'Kaczmarek', 0, 'Utrzymanie Czystości');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (21, 'user14@example.com', 'd01926adf94597454516e441789dba45148c4360a90c6eaddad59823881ab7c0', 'Barbara', 10, 2, 10, 'Krawczyk', 0, 'IT');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (22, 'user15@example.com', '5d461da41009cf778ed5998af1c9fa8781f3bed77b20f57aa4546aad3e62349b', 'Grzegorz', 6, 1, 6, 'Piotrowski', 0, 'Kadry');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (23, 'user16@example.com', '859e270ddc9686717666c0ef3e4a8fbba9a531edc9aaf823c21d695fa2a012ad', 'Monika', 2, 2, 2, 'Grabowska', 0, 'Księgowość');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (24, 'user17@example.com', 'c57b4f3ac483cacc29c0126f482eff34874bc6310fbd3730c9e929b9a0674b68', 'Łukasz', 3, 3, 3, 'Zawadzki', 0, 'Zarząd');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (25, 'user18@example.com', '10d1e10ca1161172ef145c03cd8f300072439dbb8373563ec794805cfbd47f99', 'Natalia', 1, 1, 1, 'Kubiak', 0, 'Handlowy');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (26, 'user19@example.com', '690785d293e79d089d25fe1620da4544807c34929e34b055c37f895b08ff0634', 'Wojciech', 3, 1, 3, 'Stępień', 0, 'Produkcja');
INSERT INTO quizz.users (user_id, e_mail, password, name, score, level, final_quiz, surname, is_admin, departament) VALUES (27, 'user20@example.com', '91457d748e50a04622e66332d987e0a91e703552a50531a5d9ceedfa1676e2d9', 'Dorota', 2, 2, 6, 'Michalak', 0, 'IT');
