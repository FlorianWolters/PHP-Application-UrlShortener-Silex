CREATE TABLE trim (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    original_url VARCHAR(2048) NOT NULL,
    trim_path CHAR(32) COLLATE NOCASE,
    times_called INT NOT NULL DEFAULT 0,
    created_on DATETIME NOT NULL,
    created_from_ip VARCHAR(15) NOT NULL
);
