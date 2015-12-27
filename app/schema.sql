create table bands (
    band varchar (150) primary key,
    rate int (1) unsigned,
    votes int (8) unsigned
);

create table band_rates (
    band varchar (150) key,
    rate int (1) unsigned,
    date int (10) unsigned
);
