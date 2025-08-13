async function loadAlbums() {
    const response = await fetch('albums.json');
    const albums = await response.json();
    return albums;
}

function calculateTotal(ratings) {
    return Object.values(ratings).reduce((a,b) => a+b, 0);
}

function renderAlbum(album) {
    const div = document.createElement('div');
    div.className = "album-card";

    const total = calculateTotal(album.ratings);
    div.innerHTML = `
        <img src="${album.cover_url}" alt="Cover" width="120"/>
        <div>
            <h3>${album.artist} - ${album.title}</h3>
            <p>Total: ${total} / 50</p>
            <ul>
                <li>Lyrics: ${album.ratings.lyrics}</li>
                <li>Vocals: ${album.ratings.vocals}</li>
                <li>Instrumentals: ${album.ratings.instrumentals}</li>
                <li>Production: ${album.ratings.production}</li>
                <li>Enjoyment: ${album.ratings.enjoyment}</li>
            </ul>
        </div>
    `;
    return div;
}

async function renderList(containerId) {
    const container = document.getElementById(containerId);
    const albums = await loadAlbums();
    albums.sort((a,b) => calculateTotal(b.ratings) - calculateTotal(a.ratings));
    albums.forEach(album => container.appendChild(renderAlbum(album)));
}

async function renderArtist(containerId, artistName) {
    const container = document.getElementById(containerId);
    const albums = await loadAlbums();
    albums.filter(a => a.artist.toLowerCase() === artistName.toLowerCase())
          .sort((a,b) => calculateTotal(b.ratings) - calculateTotal(a.ratings))
          .forEach(album => container.appendChild(renderAlbum(album)));
}
