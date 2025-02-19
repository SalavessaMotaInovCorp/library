<div class="relative w-full min-h-[500px] flex items-center justify-center bg-gray-100 rounded-xl shadow-xl">
<div id="drag-container">
        <div id="spin-container">
            @foreach($recentBooks as $book)
                <a target="_blank" href="/books/{{ $book->id }}">
                    <img src="{{ $book->cover_image }}" alt="">
                </a>
            @endforeach
            <p class="text-bold text-black text-4xl text-center">Latest Additions</p>
        </div>
        <div id="ground"></div>
    </div>

    <style>
        #drag-container, #spin-container {
            position: relative;
            display: flex;
            margin: auto;
            transform-style: preserve-3d;
            transform: rotateX(-10deg);
        }

        #drag-container a {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            display: block;
        }

        #drag-container img {
            width: 100%;
            height: 100%;
            box-shadow: 0 0 8px #fff;
            object-fit: cover;
        }


        #drag-container img:hover, #drag-container video:hover {
            box-shadow: 0 0 15px #fffd;
        }

        #drag-container p {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translate(-50%,-50%) rotateX(90deg);
        }

        #drag-container a {
            display: block;
        }

        #ground {
            width: 900px;
            height: 900px;
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translate(-50%,-50%) rotateX(90deg);
        }

        @keyframes spin {
            from { transform: rotateY(0deg); }
            to { transform: rotateY(360deg); }
        }

        @keyframes spinRevert {
            from { transform: rotateY(360deg); }
            to { transform: rotateY(0deg); }
        }
    </style>

    <script>
        var radius = 240;
        var autoRotate = true;
        var rotateSpeed = -60;
        var imgWidth = 120;
        var imgHeight = 170;

        setTimeout(init, 1000);

        var odrag = document.getElementById('drag-container');
        var ospin = document.getElementById('spin-container');
        var aImg = ospin.getElementsByTagName('img');
        var aVid = ospin.getElementsByTagName('video');
        var aEle = [...aImg, ...aVid];

        ospin.style.width = imgWidth + "px";
        ospin.style.height = imgHeight + "px";

        var ground = document.getElementById('ground');
        ground.style.width = radius * 3 + "px";
        ground.style.height = radius * 3 + "px";

        function init(delayTime) {
            for (var i = 0; i < aEle.length; i++) {
                aEle[i].style.transform = "rotateY(" + (i * (360 / aEle.length)) + "deg) translateZ(" + radius + "px)";
                aEle[i].style.transition = "transform 1s";
                aEle[i].style.transitionDelay = delayTime || (aEle.length - i) / 4 + "s";
            }
        }

        function applyTranform(obj) {
            if(tY > 180) tY = 180;
            if(tY < 0) tY = 0;
            obj.style.transform = "rotateX(" + (-tY) + "deg) rotateY(" + (tX) + "deg)";
        }

        function playSpin(yes) {
            ospin.style.animationPlayState = (yes ? 'running' : 'paused');
        }

        var sX, sY, nX, nY, desX = 0,
            desY = 0,
            tX = 0,
            tY = 10;

        if (autoRotate) {
            var animationName = (rotateSpeed > 0 ? 'spin' : 'spinRevert');
            ospin.style.animation = `${animationName} ${Math.abs(rotateSpeed)}s infinite linear`;
        }

        document.onpointerdown = function (e) {
            clearInterval(odrag.timer);
            e = e || window.event;
            var sX = e.clientX,
                sY = e.clientY;

            this.onpointermove = function (e) {
                e = e || window.event;
                var nX = e.clientX,
                    nY = e.clientY;
                desX = nX - sX;
                desY = nY - sY;
                tX += desX * 0.1;
                tY += desY * 0.1;
                applyTranform(odrag);
                sX = nX;
                sY = nY;
            };

            this.onpointerup = function () {
                odrag.timer = setInterval(function () {
                    desX *= 0.95;
                    desY *= 0.95;
                    tX += desX * 0.1;
                    tY += desY * 0.1;
                    applyTranform(odrag);
                    playSpin(false);
                    if (Math.abs(desX) < 0.5 && Math.abs(desY) < 0.5) {
                        clearInterval(odrag.timer);
                        playSpin(true);
                    }
                }, 17);
                this.onpointermove = this.onpointerup = null;
            };

            return false;
        };

        // document.onmousewheel = function(e) {
        //     e = e || window.event;
        //     var d = e.wheelDelta / 20 || -e.detail;
        //     radius += d;
        //     init(1);
        // };
    </script>
</div>
