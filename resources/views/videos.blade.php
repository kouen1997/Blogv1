<!DOCTYPE HTML>
<!--
    Future Imperfect by HTML5 UP
    html5up.net | @ajlkn
    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
    <head>
        <title>Single - Future Imperfect by HTML5 UP</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="icon" href="{{ URL::asset('assets/images/Running_Man_logo_as_of_2017.png') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        <link rel="stylesheet" href="{{ URL::asset('assets/media/mediaelementplayer.css') }}">

        <link rel="stylesheet" href="{{ URL::asset('assets/media/jump-forward/jump-forward.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/media/skip-back/skip-back.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/media/speed/speed.css') }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/placeholder-loading/dist/css/placeholder-loading.min.css">

        <style type="text/css">
            .mejs__time-rail .mejs__time-loaded, .mejs__time-current, .mejs__time-handle{
                background-color: yellow;
            }
            .mejs__time-rail .mejs__time-slider > 
            .mejs__time-buffering{
                background-color: yellow;
            }
        </style>
    </head>
    <body>

        <h2>Video Player</h2>
        <div class="container">
            <div class="row" style="margin-left: -10em;">
                <div class="col-md-12">
                    <div class="media-wrapper" style="padding:0px;border: 1px solid #000; align-content: center;">
                        <video id="player1" width="1255" height="700" controls preload="none" poster="http://mediaelementjs.com/images/big_buck_bunny.jpg">
                            <source type="application/x-mpegURL" src="https://video-dev.github.io/streams/x36xhzz/x36xhzz.m3u8" data-quality="HD">
                            <source type="video/mp4" src="https://commondatastorage.googleapis.com/gtv-videos-bucket/CastVideos/mp4/BigBuckBunny.mp4" data-quality="SD">
                            <source type="video/mp4" src="http://clips.vorwaerts-gmbh.de/big_buck_bunny.mp4" data-quality="LD">
                        </video>
                    </div>
                    <small>@username</small>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.6/mediaelement-and-player.min.js"></script>
        <script src="{{ URL::asset('assets/media/jump-forward/jump-forward.js') }}"></script>
        <script src="{{ URL::asset('assets/media/skip-back/skip-back.js') }}"></script>
        <script src="{{ URL::asset('assets/media/speed/speed.js') }}"></script>

        <script>
            var mediaElements = document.querySelectorAll('video, audio');

            for (var i = 0, total = mediaElements.length; i < total; i++) {

                new MediaElementPlayer(mediaElements[i], {
                    features: features = ['playpause', 'current', 'progress', 'duration', 'volume', 'skipback', 'jumpforward', 'fullscreen'],
                });
            }
        </script>
    </body>
</html>