<style>
    .loader { display: none; position: fixed; top: 0; bottom: 0; left: 0; right: 0; background: #00000066; z-index: 1; justify-content: center; align-items: center}
    .loader div { margin: auto; }
    body.loading .loader { display: flex; }
    .stopwatch { position: absolute; color: white; font-size: 24px; }
    .timer { position: relative; top: -50px; }
    .footer { position: fixed; left: 0; bottom: 0; right: 0; background-color: #f3f3f3; box-shadow: 1px 1px 6px #ababab; font-size: 12px; text-align: center; }
</style>
<div class="loader">
    <div class="stopwatch">
        <div class="timer">
            <span>Waiting Time:</span> <span class="seconds">0</span><span>s</span>
        </div>
    </div>
    <script>
        const timer = {};
        timer.seconds = 0;
        timer.component = document.querySelector(".seconds"); 
        timer.interval = null; 
        timer.timestart = ()=>{
            document.querySelector("body").classList.toggle("loading");
            timer.component.innerHTML = 0; 
            timer.seconds = 0;
            timer.interval = window.setInterval(()=>{
                timer.seconds+=1;
                timer.component.innerHTML = timer.seconds;
            }, 1000);
        };
        timer.timestop = ()=>{
            document.querySelector("body").classList.toggle("loading");
            window.clearInterval(timer.interval);
            document.querySelector(".footer").innerHTML=`Time for the last query: ${timer.seconds}s`;
        };
    </script>
    <div class="spinner-border" role="status">
        <span class="sr-only"></span>
    </div>
</div>
<div class="footer"></div>