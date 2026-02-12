CREATE DATABASE echange_revision;
\c echange_revision;

CREATE TABLE users_roles (
    id SERIAL PRIMARY KEY,
    rang integer,
    nom VARCHAR(100)
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    id_roles INTEGER REFERENCES users_roles(id),
    nom VARCHAR(100),
    mdp VARCHAR(100),
    mail VARCHAR(100),
    numero VARCHAR(100),
    date_ajout timestamp without time zone NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE items_categorie (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100)
);

CREATE TABLE items (
    id SERIAL PRIMARY KEY,
    id_items_categorie INTEGER REFERENCES items_categorie(id),
    photo varchar,
    nom varchar,
    prix DOUBLE PRECISION,
    date_ajout timestamp without time zone NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE item_users (
    id SERIAL PRIMARY KEY,
    id_users INTEGER REFERENCES users(id),
    id_items INTEGER REFERENCES items(id),
    etat boolean,
    date_ajout timestamp without time zone NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE echange_transaction (
    id SERIAL PRIMARY KEY,
    id_users1 INTEGER REFERENCES users(id),
    id_users2 INTEGER REFERENCES users(id),
    id_items1 INTEGER REFERENCES items(id),
    id_items2 INTEGER REFERENCES items(id),
    date_ajout timestamp without time zone NULL DEFAULT CURRENT_TIMESTAMP
);