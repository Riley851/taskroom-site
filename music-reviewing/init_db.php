<?php
$db = new SQLite3('albums.db');
$db->exec("CREATE TABLE IF NOT EXISTS albums (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist TEXT,
    title TEXT,
    cover_url TEXT,
    lyrics INTEGER,
    vocals INTEGER,
    instrumentals INTEGER,
    production INTEGER,
    enjoyment INTEGER,
    total INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");
echo "Database initialized.";
?>
