<?php
$db = new SQLite3('albums.db');
$results = $db->query("SELECT * FROM albums ORDER BY total DESC");
?>
<h1>My Album Ratings</h1>
<?php while($row = $results->fetchArray(SQLITE3_ASSOC)): ?>
    <div style="border:1px solid #ccc;padding:10px;margin:10px;display:flex;">
        <img src="<?=$row['cover_url']?>" alt="Cover" width="100" style="margin-right:10px"/>
        <div>
            <strong><a href="artist.php?artist=<?=urlencode($row['artist'])?>"><?=$row['artist']?></a> - <?=$row['title']?></strong><br/>
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
