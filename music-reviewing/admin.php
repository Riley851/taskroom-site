<?php
session_start();
if(!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit; }

function fetch_cover($artist, $title){
    $query = urlencode("$artist $title");
    $json = file_get_contents("https://musicbrainz.org/ws/2/release/?query=$query&fmt=json&limit=1");
    $data = json_decode($json, true);
    if(isset($data['releases'][0]['id'])){
        $mbid = $data['releases'][0]['id'];
        return "https://coverartarchive.org/release/$mbid/front";
    }
    return "";
}

$fields = ['lyrics','vocals','instrumentals','production','enjoyment'];

if(isset($_POST['artist'])){
    $artist = $_POST['artist'];
    $title = $_POST['title'];
    $ratings = [];
    $total = 0;
    foreach($fields as $f){
        $ratings[$f] = intval($_POST[$f]);
        $total += $ratings[$f];
    }
    $cover = fetch_cover($artist,$title);

    $db = new SQLite3('albums.db');
    $stmt = $db->prepare("INSERT INTO albums 
        (artist,title,cover_url,lyrics,vocals,instrumentals,production,enjoyment,total)
        VALUES (:artist,:title,:cover,:lyrics,:vocals,:instrumentals,:production,:enjoyment,:total)");
    $stmt->bindValue(':artist',$artist);
    $stmt->bindValue(':title',$title);
    $stmt->bindValue(':cover',$cover);
    foreach($fields as $f){ $stmt->bindValue(":$f",$ratings[$f]); }
    $stmt->bindValue(':total',$total);
    $stmt->execute();
    $success = "Album added!";
}
?>
<h2>Add Album</h2>
<?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
<form method="POST">
    <input name="artist" placeholder="Artist" required/><br/>
    <input name="title" placeholder="Album Title" required/><br/>
    <?php foreach($fields as $f): ?>
        <label><?=ucfirst($f)?> (1-10)</label>
        <input type="number" name="<?=$f?>" min="1" max="10" required/><br/>
    <?php endforeach; ?>
    <button type="submit">Add Album</button>
</form>
<a href="list.php">View public list</a>
