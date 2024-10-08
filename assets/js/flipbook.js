document.addEventListener('DOMContentLoaded', function() {
    // Initialize Turn.js
    $('#flipbook').turn({
        width: 800,
        height: 600,
        autoCenter: true
    });

    // Load PDF pages
    pdfjsLib.getDocument(`assets/uploads/${flipbook.filename}`).promise.then(function(pdf) {
        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            pdf.getPage(pageNum).then(function(page) {
                const scale = 1.5;
                const viewport = page.getViewport({ scale: scale });
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext);

                $('#flipbook').turn('addPage', canvas, pageNum);
            });
        }
    });

    // Background Music
    const audio = document.getElementById('background-music');
    const playPauseBtn = document.getElementById('play-pause');
    const prevTrackBtn = document.getElementById('prev-track');
    const nextTrackBtn = document.getElementById('next-track');

    const playlist1 = [
        'assets/music/playlist1/01_sky_kisses_earth.m4a',
        'assets/music/playlist1/05_The_Seventh_Eclipse.m4a',
        'assets/music/playlist1/CVRTOON.mp3'
    ];
    let currentTrack = 0;

    function loadTrack() {
        audio.src = playlist1[currentTrack];
        audio.load();
    }

    playPauseBtn.addEventListener('click', function() {
        if (audio.paused) {
            audio.play();
        } else {
            audio.pause();
        }
    });

    prevTrackBtn.addEventListener('click', function() {
        currentTrack = (currentTrack - 1 + playlist1.length) % playlist1.length;
        loadTrack();
        audio.play();
    });

    nextTrackBtn.addEventListener('click', function() {
        currentTrack = (currentTrack + 1) % playlist1.length;
        loadTrack();
        audio.play();
    });

    // Start playing when flipbook is opened
    $('#flipbook').on('turned', function(event, page, view) {
        if (page === 1) {
            audio.play();
        }
    });

    // Prevent error on page 1
    $('#flipbook').on('start', function(event, pageObject, corner) {
        if (pageObject.page === 1 && corner === 'tl') {
            event.preventDefault();
        }
    });
});