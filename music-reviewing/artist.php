<?php
$db = new SQLite3('albums.db');
$artist = $_GET['artist'] ?? '';
$artist_esc = SQLite3::escapeString($artist);
$results = $db->query("SELECT * FROM albums WHERE artist='$artist_esc' ORDER BY total DESC");
?>
<h1>Albums by <?=$artist?></h1>
<?php while($row = $results->fetchArray(SQLITE3_ASSOC)): ?>
    <div style="border:1px solid #ccc;padding:10px;margin:10px;display:flex;">
        <img src="<?=$row['cover_url']?>" alt="Cover" width="100" style="margin-right:10px"/>
        <div>
            <strong><?=$row['title']?></strong><br/>
            Total: <?=$row['total']?> / 50<br/>
            <ul>
                <?php
                foreach(['lyrics','vocals','instrumentals','production','enjoyment'] as $f){
                    echo "<li>".ucfirst($f).": ".$row[$f]."</li>";
                }
                ?>
            </ul>
        </div>
    </div>
<?php endwhile; ?>
<a href="list.php">Back to all albums</a>
