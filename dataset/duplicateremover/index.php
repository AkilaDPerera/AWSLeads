<!DOCTYPE html>
<html lang="en">
<?php
    require '../backend/constant.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duplicate Remover</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <style>
        .loader { display: none; position: fixed; top: 0; bottom: 0; left: 0; right: 0; background: #00000066; z-index: 1; justify-content: center; align-items: center}
        .loader div { margin: auto; }
        body.loading .loader { display: flex; }
    </style>
    <style>
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
                timer.component.innerHTML = 0; 
                timer.seconds = 0;
                timer.interval = window.setInterval(()=>{
                    timer.seconds+=1;
                    timer.component.innerHTML = timer.seconds;
                }, 1000);
            };
            timer.timestop = ()=>{
                window.clearInterval(timer.interval);
                document.querySelector(".footer").innerHTML=`Time for the last query: ${timer.seconds}s`;
            };
        </script>
        <div class="spinner-border" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
    <div class="footer"></div>

    <div class="container mt-4">
        <h3>Duplicate Remover</h3>
        <div class="mt-4">
            <img height="200" src="https://cdn.shopify.com/s/files/1/0027/0578/4877/files/leftexclusive.png?v=1728401026" alt="left exclusive"/>
        </div>
        <div class="row mt-4">
            <div class="col-6">
                <div class="h4">(A) Dataset</div>
                <div class="field exceptionuploadA uploadable">
                    <div class="mb-2">Please insert line separated list of values file.</div>
                    <form id="uploadformA" method="post" enctype="multipart/form-data" 
                    action="<?php echo $baseurl ?>duplicateremover/backend/uploadA.php" >
                        <!-- <div class="leadingone">
                            <input type="checkbox" name="leadingone" id="leadingoneA"/>    
                            <label for="leadingoneA">Remove leading 1</label>
                        </div> -->
                        <div style="display: inline-flex; align-items: center;" >
                            <input class="form-control input me-1" type="file" id="fileA" name="fileA" accept=".txt,.csv" required>
                            <input class="btn btn-primary" id="uploadA" type="submit" value="Upload">
                            <div class="download me-1"><a href="<?php echo $baseurl ?>duplicateremover/uploads" target="_blank">Download</a></div>
                            <button type="button" id="clearA" class="btn btn-primary ms-1" onclick="clearuploadsA();">Clear</button>
                        </div>
                    </form>
                </div>

                <style>
                    .exceptionuploadA.uploadable #fileA, .exceptionuploadA.uploadable #uploadA { display: inline-block; }
                    .exceptionuploadA.uploadable .leadingone { display: block; }
                    .exceptionuploadA.uploadable .download, .exceptionuploadA.uploadable #clearA { display: none; }
                    .exceptionuploadA #fileA, .exceptionuploadA #uploadA, .exceptionuploadA .leadingone { display: none; }
                    .exceptionuploadA .download, .exceptionuploadA #clearA { display: inline-block; }
                </style>

                <script>
                    form = document.querySelector(".exceptionuploadA #uploadformA"); 
                    form.addEventListener('submit', handleSubmitA);
                    function handleSubmitA(event) {
                        event.preventDefault();
                        const form = event.currentTarget;
                        const url = new URL(form.action);
                        const formData = new FormData(form);
                        timer.timestart(); document.querySelector("body").classList.toggle("loading");
                        fetch(url, {
                            method: form.method,
                            body: formData,
                            enctype: 'multipart/form-data',
                        })
                        .then((payload) => {
                            timer.timestop(); document.querySelector("body").classList.toggle("loading");
                            setUploadableA(false);
                        })
                        .catch((error) => {
                            console.error('Upload failed', error);
                            document.querySelector(".footer").innerHTML=`Something is wrong. Upload failed.`;
                        });
                    }
                    clearuploadsA = ()=>{
                        document.querySelector(".result a").style.display = "none";
                        timer.timestart(); document.querySelector("body").classList.toggle("loading");
                        fetch("<?php echo $baseurl ?>duplicateremover/backend/clearA.php")
                        .then(()=>{
                            setUploadableA(true);
                            timer.timestop(); document.querySelector("body").classList.toggle("loading");
                        });
                    }
                    setUploadableA = (uploadable)=>{
                        if (uploadable){
                            document.querySelector(".exceptionuploadA").classList.contains("uploadable")?null:document.querySelector(".exceptionuploadA").classList.add("uploadable");
                        }else{
                            document.querySelector(".exceptionuploadA").classList.contains("uploadable")?document.querySelector(".exceptionuploadA").classList.remove("uploadable"):null;
                        }
                        if (document.querySelector(".exceptionuploadA.uploadable")==null && document.querySelector(".exceptionuploadB.uploadable")==null){
                            document.querySelector(".result").style.display = "block";
                        } else {
                            document.querySelector(".result").style.display = "none";
                        }
                    }
                    fetch("<?php echo $baseurl ?>duplicateremover/backend/isAthere.php").then((res)=>res.text()).then((data)=>{
                        if (data=="false"){
                            setUploadableA(true);
                        } else {
                            setUploadableA(false);
                        }
                    });
                </script>
                
            </div>
            <div class="col-6">
                <div class="h4">(B) Dataset</div>

                <div class="field exceptionuploadB uploadable">
                <div class="mb-2">Please insert line separated list of values file.</div>
                    <form id="uploadformB" method="post" enctype="multipart/form-data" 
                    action="<?php echo $baseurl ?>duplicateremover/backend/uploadB.php" >
                        <!-- <div class="leadingone">
                            <input type="checkbox" name="leadingone" id="leadingoneB"/>    
                            <label for="leadingoneB">Remove leading 1</label>
                        </div> -->
                        <div style="display: inline-flex; align-items: center;">
                            <input class="form-control input me-1" type="file" id="fileB" name="fileB" accept=".txt,.csv" required>
                            <input class="btn btn-primary" id="uploadB" type="submit" value="Upload">
                            <div class="download me-1"><a href="<?php echo $baseurl ?>duplicateremover/uploads" target="_blank">Download</a></div>
                            <button type="button" id="clearB" class="btn btn-primary ms-1" onclick="clearuploadsB();">Clear</button>
                        </div>
                    </form>
                </div>

                <style>
                    .exceptionuploadB.uploadable #fileB, .exceptionuploadB.uploadable #uploadB { display: inline-block; }
                    .exceptionuploadB.uploadable .leadingone { display: block; }
                    .exceptionuploadB.uploadable .download, .exceptionuploadB.uploadable #clearB { display: none; }
                    .exceptionuploadB #fileB, .exceptionuploadB #uploadB, .exceptionuploadB .leadingone { display: none; }
                    .exceptionuploadB .download, .exceptionuploadB #clearB { display: inline-block; }
                </style>

                <script>
                    form = document.querySelector(".exceptionuploadB #uploadformB"); 
                    form.addEventListener('submit', handleSubmitB);
                    function handleSubmitB(event) {
                        event.preventDefault();
                        const form = event.currentTarget;
                        const url = new URL(form.action);
                        const formData = new FormData(form);
                        timer.timestart(); document.querySelector("body").classList.toggle("loading");
                        fetch(url, {
                            method: form.method,
                            body: formData,
                            enctype: 'multipart/form-data',
                        })
                        .then((payload) => {
                            timer.timestop(); document.querySelector("body").classList.toggle("loading");
                            setUploadableB(false);
                        })
                        .catch((error) => {
                            console.error('Upload failed', error);
                            document.querySelector(".footer").innerHTML=`Something is wrong. Upload failed.`;
                        });
                    }
                    clearuploadsB = ()=>{
                        document.querySelector(".result a").style.display = "none";
                        timer.timestart(); document.querySelector("body").classList.toggle("loading");
                        fetch("<?php echo $baseurl ?>duplicateremover/backend/clearB.php")
                        .then(()=>{
                            setUploadableB(true);
                            timer.timestop(); document.querySelector("body").classList.toggle("loading");
                        });
                    }
                    setUploadableB = (uploadable)=>{
                        if (uploadable){
                            document.querySelector(".exceptionuploadB").classList.contains("uploadable")?null:document.querySelector(".exceptionuploadB").classList.add("uploadable");
                        }else{
                            document.querySelector(".exceptionuploadB").classList.contains("uploadable")?document.querySelector(".exceptionuploadB").classList.remove("uploadable"):null;
                        }
                        if (document.querySelector(".exceptionuploadA.uploadable")==null && document.querySelector(".exceptionuploadB.uploadable")==null){
                            document.querySelector(".result").style.display = "block";
                        } else {
                            document.querySelector(".result").style.display = "none";
                        }
                    }
                    fetch("<?php echo $baseurl ?>duplicateremover/backend/isBthere.php").then((res)=>res.text()).then((data)=>{
                        if (data=="false"){
                            setUploadableB(true);
                        } else {
                            setUploadableB(false);
                        }
                    });
                </script>
            </div>
        </div>
        <hr/>
        <div class="result row mt-4" style="display: none;">
            <div class="col-12">
                <button class="btn btn-primary" onclick="calculate();">Calculate</button>
                <a style="display: none;" href="<?php echo $baseurl ?>duplicateremover/result/result.csv" target="_blank">Download Result</a>
            </div>
            <script>
                function calculate() {
                    timer.timestart(); document.querySelector("body").classList.toggle("loading");
                    fetch("<?php echo $baseurl ?>duplicateremover/backend/calc.php")
                    .then((res) => {
                        timer.timestop(); document.querySelector("body").classList.toggle("loading");
                        document.querySelector(".result a").style.display = "inline-block";
                    })
                    .catch((error) => {
                        console.error('Calc failed', error);
                        document.querySelector(".footer").innerHTML=`Something is wrong.`;
                    });
                }
            </script>
        </div>
    </div>
</body>
</html>