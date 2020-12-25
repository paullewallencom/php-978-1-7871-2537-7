CREATE DATABASE finding_secrets;

USE finding_secrets;

CREATE TABLE secrets (
  "id" INT UNSIGNED NOT NULL AUTO_INCREMENT,
  "name" VARCHAR(255) NOT NULL,
  "creation_time" TIMESTAMP NOT NULL,
  "latitude" FLOAT NOT NULL DEFAULT 0.0,
  "longitude" FLOAT NOT NULL DEFAULT 0.0,
  "location_name" VARCHAR(255) NOT NULL,
  PRIMARY KEY ("id")
);

INSERT INTO "finding_secrets" ("id", "name", "creation_time" "latitude", "longitude", "location_name")
  VALUES (1, "amber", NOW(), 42.8805, -8.54569, "Santiago de Compostela");

INSERT INTO "finding_secrets" ("id", "name", "creation_time" "latitude", "longitude", "location_name")
  VALUES (2, "diamond", NOW(), 38.2622, -0.70107, "Elche");

INSERT INTO "finding_secrets" ("id", "name", "creation_time" "latitude", "longitude", "location_name")
  VALUES (3, "pearl", NOW(), 41.8919, 12.5113, "Rome");

INSERT INTO "finding_secrets" ("id", "name", "creation_time" "latitude", "longitude", "location_name")
  VALUES (4, "ruby", NOW(), 53.4106, -2.9779, "Liverpool");

INSERT INTO "finding_secrets" ("id", "name", "creation_time" "latitude", "longitude", "location_name")
  VALUES (5, "sapphire", NOW(), 50.08804, 14.42076, "Prague");
