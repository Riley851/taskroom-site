let albums = [];

document.getElementById('jsonInput').addEventListener('input', e => {
    try { albums = JSON.parse(e.target.value) } catch {}
});

document.getElementById('albumForm').addEventListener('submit', e => {
    e.preventDefault();
    const newAlbum = {
        artist: document.getElementById('artist').value,
        title: document.getElementById('title').value,
        cover_url: document.getElementById('cover_url').value,
        ratings: {
            lyrics: parseInt(document.getElementById('lyrics').value),
            vocals: parseInt(document.getElementById('vocals').value),
            instrumentals: parseInt(document.getElementById('instrumentals').value),
            production: parseInt(document.getElementById('production').value),
            enjoyment: parseInt(document.getElementById('enjoyment').value)
        }
    };
    albums.push(newAlbum);
    alert("Album added! Scroll down to export JSON.");
});

document.getElementById('exportBtn').addEventListener('click', () => {
    const jsonStr = JSON.stringify(albums, null, 2);
    prompt("Copy this updated JSON to albums.json:", jsonStr);
});
