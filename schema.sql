CREATE TABLE profiles (
  profile_id INTEGER PRIMARY KEY,
  profile_name TEXT NOT NULL,
  business_name TEXT,
  email TEXT,
  phone TEXT,
  address_1 TEXT,
  address_2 TEXT,
  address_3 TEXT
) STRICT;

CREATE TABLE clients (
  client_id INTEGER PRIMARY KEY,
  business_name TEXT NOT NULL,
  email TEXT,
  phone TEXT,
  address_1 TEXT,
  address_2 TEXT,
  address_3 TEXT
) STRICT;
