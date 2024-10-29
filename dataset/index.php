<!DOCTYPE html>
<html lang="en">
    <?php
        require_once 'backend/constant.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Business Database</title>
        <link rel="icon" type="image/png" href="/logo.png">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@3.0.1/dist/css/multi-select-tag.css">
        <script src="./multiselect-dropdown.js"></script>
        <!-- https://www.cssscript.com/filterable-checkable-multi-select/#google_vignette -->
    </head>
    <body>

        <?php 
            require_once 'components/getAuthenticated.php';
        ?>
        <div style="position: fixed; right: 0; top: 0;">
            <div class="d-flex align-items-center">
                <button class="btn btn-link" onclick="logout()">logout</button>
            </div>
        </div>

        <style>
            .loader { display: none; position: fixed; top: 0; bottom: 0; left: 0; right: 0; background: #00000066; z-index: 1; justify-content: center; align-items: center}
            .loader div { margin: auto; }
            body.loading .loader { display: flex; }
        </style>
        <style>
            .main-options { margin: 10px 20px; }
            .field { display: inline-block; vertical-align: top; margin: 5px 0; }
            .field-block { display: block; }
            #show_count { margin-left: 5px; font-size: 20px; vertical-align: middle; }
            .tablelist { margin: 0 20px; }
            #downloadable[disabled="disabled"] { display: none; }
            .hide { display: none!important; }
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
        
        <div class="main-options">
            <div class="field field-block">
                <label for="industry">Industry</label>
                <input type="text" name="industry" id="industry" class="form-control" >
            </div>
            <div class="field">
                <label for="cname">Company Name</label>
                <input type="text" name="cname" id="cname" class="form-control">
            </div>
            <div class="field">
                <label for="city">City</label>
                <input type="text" name="city" id="city" class="form-control">
            </div>
            <div class="field">
                <label for="state">State</label>
                <select name="state" id="state" class="state form-control" multiple multiselect-select-all="true" multiselect-search="true">
                    <option value="ak">AK</option>
                    <option value="al">AL</option>
                    <option value="ar">AR</option>
                    <option value="az">AZ</option>
                    <option value="ca">CA</option>
                    <option value="co">CO</option>
                    <option value="ct">CT</option>
                    <option value="dc">DC</option>
                    <option value="de">DE</option>
                    <option value="fl">FL</option>
                    <option value="ga">GA</option>
                    <option value="gu">GU</option>
                    <option value="hi">HI</option>
                    <option value="ia">IA</option>
                    <option value="id">ID</option>
                    <option value="il">IL</option>
                    <option value="in">IN</option>
                    <option value="ks">KS</option>
                    <option value="ky">KY</option>
                    <option value="la">LA</option>
                    <option value="ma">MA</option>
                    <option value="md">MD</option>
                    <option value="me">ME</option>
                    <option value="mi">MI</option>
                    <option value="mn">MN</option>
                    <option value="mo">MO</option>
                    <option value="ms">MS</option>
                    <option value="mt">MT</option>
                    <option value="nc">NC</option>
                    <option value="nd">ND</option>
                    <option value="ne">NE</option>
                    <option value="nh">NH</option>
                    <option value="nj">NJ</option>
                    <option value="nm">NM</option>
                    <option value="nv">NV</option>
                    <option value="ny">NY</option>
                    <option value="oh">OH</option>
                    <option value="ok">OK</option>
                    <option value="or">OR</option>
                    <option value="pa">PA</option>
                    <option value="pr">PR</option>
                    <option value="ri">RI</option>
                    <option value="sc">SC</option>
                    <option value="sd">SD</option>
                    <option value="tn">TN</option>
                    <option value="tx">TX</option>
                    <option value="ut">UT</option>
                    <option value="va">VA</option>
                    <option value="vi">VI</option>
                    <option value="vt">VT</option>
                    <option value="wa">WA</option>
                    <option value="wi">WI</option>
                    <option value="wv">WV</option>
                    <option value="wy">WY</option>
                </select>
            </div>
            <div class="field">
                <label for="phonetype">Phone Type</label>
                <select name="phonetype" id="phonetype" class="phonetype form-control" multiple>
                    <option value="mobile">Mobile</option>
                    <option value="landline">Landline</option>
                    <option value="blank">Blank</option>
                </select>
            </div>
            <div class="field">
                <label for="category">Category</label>
                <select id="category" name="category" class="category form-control" multiple multiselect-select-all="true" multiselect-search="true">
                    <option value="contractor-1">contractor-1</option>
                    <option value="contractor-2">contractor-2</option>
                    <option value="contractor-3">contractor-3</option>
                    <option value="contractor-4">contractor-4</option>
                    <option value="misc-1">misc-1</option>
                    <option value="misc-2">misc-2</option>
                    <option value="misc-3">misc-3</option>
                    <option value="misc-4">misc-4</option>
                    <option value="misc-5">misc-5</option>
                    <option value="misc-6">misc-6</option>
                    <option value="misc-7">misc-7</option>
                    <option value="misc-8">misc-8</option>
                    <option value="misc-9">misc-9</option>
                    <option value="misc-10">misc-10</option>
                    <option value="misc-11">misc-11</option>
                    <option value="misc-12">misc-12</option>
                    <option value="misc-13">misc-13</option>
                    <option value="retail-1">retail-1</option>
                    <option value="retail-2">retail-2</option>
                    <option value="retail-3">retail-3</option>
                    <option value="retail-4">retail-4</option>
                    <option value="services-1">services-1</option>
                    <option value="services-2">services-2</option>
                    <option value="services-3">services-3</option>
                    <option value="services-4">services-4</option>
                </select>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <div class="field" >
                    <button id="industry-btn" class="btn btn-primary">Search</button>
                    <button id="count-btn" class="btn btn-primary">Preview</button>
                    <span id="show_count"></span>
                </div>
                <div class="field" id="downloadable" disabled="disabled">
                    <a style="font-size: 13px;" href="/data/" target="_blank">Download Full List</a>
                    <button id="save" class="btn btn-primary">Save as CSV</button>
                </div>
            </div>

            <div class="accordion my-3" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button style="background: var(--bs-accordion-active-bg);" class="accordion-button collapsed h2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Phone number exceptions
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="field exceptionupload uploadable">
                                <div class="mb-2">Please insert line separated list of phone number file to temporary omit from the query result.</div>
                                <form style="display: inline-flex; align-items: center;" id="uploadform" method="post" enctype="multipart/form-data" action="<?php echo $baseurl ?>backend/exceptions/uploadexceptions.php" >
                                    <input class="form-control input me-1" type="file" id="file" name="file" accept=".txt,.csv" required>
                                    <input class="btn btn-primary" id="upload" type="submit" value="Upload">
                                    <div class="download me-1"><a href="<?php echo $baseurl ?>exception/exceptionlist.csv" target="_blank">Download existing exception list</a></div>
                                    <button type="button" id="clear" class="btn btn-primary ms-1" onclick="clearuploads();">Clear</button>
                                </form>
                            </div>

                            <style>
                                .exceptionupload.uploadable #file, .exceptionupload.uploadable #upload { display: inline-block; }
                                .exceptionupload.uploadable .download, .exceptionupload.uploadable #clear { display: none; }
                                .exceptionupload #file, .exceptionupload #upload { display: none; }
                                .exceptionupload .download, .exceptionupload #clear { display: inline-block; }
                            </style>

                            <script>
                                form = document.querySelector(".exceptionupload #uploadform"); 
                                form.addEventListener('submit', handleSubmit);
                                function handleSubmit(event) {
                                    event.preventDefault();
                                    const form = event.currentTarget;
                                    const url = new URL(form.action);
                                    const formData = new FormData(form);
                                    formData.append("jwt", window.localStorage.getItem("jwt"));
                                    timer.timestart(); document.querySelector("body").classList.toggle("loading");
                                    fetch(url, {
                                        method: form.method,
                                        body: formData,
                                        enctype: 'multipart/form-data',
                                    })
                                    .then((payload) => {
                                        timer.timestop(); document.querySelector("body").classList.toggle("loading");
                                        setUploadable(false);
                                    })
                                    .catch((error) => {
                                        console.error('Upload failed', error);
                                        document.querySelector(".footer").innerHTML=`Something is wrong. Upload failed.`;
                                    });
                                }
                                clearuploads = ()=>{
                                    timer.timestart(); document.querySelector("body").classList.toggle("loading");
                                    fetch("<?php echo $baseurl ?>backend/exceptions/clearuploadexceptions.php")
                                    .then(()=>{
                                        setUploadable(true);
                                        timer.timestop(); document.querySelector("body").classList.toggle("loading");
                                    });
                                }
                                setUploadable = (uploadable)=>{
                                    if (uploadable){
                                        document.querySelector(".exceptionupload").classList.contains("uploadable")?null:document.querySelector(".exceptionupload").classList.add("uploadable");
                                    }else{
                                        document.querySelector(".exceptionupload").classList.contains("uploadable")?document.querySelector(".exceptionupload").classList.remove("uploadable"):null;
                                    }
                                }
                                fetch("<?php echo $baseurl ?>backend/exceptions/isexceptionlistuploaded.php").then((res)=>res.text()).then((data)=>{
                                    if (data=="false"){
                                        setUploadable(true);
                                    } else {
                                        document.querySelector("#collapseOne").classList.contains("show")?null:document.querySelector("#collapseOne").classList.add("show");
                                        setUploadable(false);
                                    }
                                })
                            </script>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button style="background: var(--bs-accordion-active-bg);" class="accordion-button collapsed h2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Submissions for phone number removal
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="field removeupload uploadable">
                                <div class="mb-2">
                                    Removal process begins 00:00 in everyday. Please visit the following link to see the pending removal processes. 
                                    <a class="ms-1" href="<?php echo $baseurl ?>pendingremovals/" target="_blank">PENDING REMOVALS</a>
                                    <br>
                                    Removal submissions: <a class="ms-1" href="<?php echo $baseurl ?>removals/" target="_blank">REMOVALS</a>
                                </div>
                                <ul class="removalslist"></ul>
                                <form style="display: inline-flex; align-items: center;" id="uploadform" method="post" enctype="multipart/form-data" action="<?php echo $baseurl ?>backend/removals/uploadremovals.php" >
                                    <input class="form-control input me-1" type="file" id="file" name="file" accept=".txt,.csv" required >
                                    <input class="btn btn-primary" id="upload" type="submit" value="Upload">
                                    <button type="button" id="clear" class="btn btn-primary ms-1" onclick="clearremovalsuploads()">Clear</button>
                                </form>
                            </div>

                            <script>
                                form = document.querySelector(".removeupload #uploadform"); 
                                form.addEventListener('submit', handleSubmit);
                                function handleSubmit(event) {
                                    event.preventDefault();
                                    const form = event.currentTarget;
                                    const url = new URL(form.action);
                                    const formData = new FormData(form);
                                    formData.append("jwt", window.localStorage.getItem("jwt"));
                                    timer.timestart(); document.querySelector("body").classList.toggle("loading");
                                    fetch(url, {
                                        method: form.method,
                                        body: formData,
                                        enctype: 'multipart/form-data',
                                    })
                                    .then((payload) => {
                                        timer.timestop(); document.querySelector("body").classList.toggle("loading");
                                        getremovals();
                                    })
                                    .catch((error) => {
                                        console.error('Upload failed', error);
                                        document.querySelector(".footer").innerHTML=`Something is wrong. Upload failed.`;
                                    });
                                }
                                clearremovalsuploads = ()=>{
                                    timer.timestart(); document.querySelector("body").classList.toggle("loading");
                                    fetch("<?php echo $baseurl ?>backend/removals/clearremovals.php").then(()=>{
                                        getremovals();
                                        timer.timestop(); document.querySelector("body").classList.toggle("loading");
                                    });
                                }
                                getremovals = ()=>{
                                    fetch("<?php echo $baseurl ?>backend/removals/listremovals.php").then((res)=>res.json()).then((data)=>{
                                        var remlist = "";
                                        data.forEach((name)=>{
                                            remlist += `<li>${name}</li>`;
                                        });
                                        document.querySelector(".removeupload .removalslist").innerHTML=remlist;
                                        if (data.length!=0){
                                            document.querySelector("#collapseTwo").classList.contains("show")?null:document.querySelector("#collapseTwo").classList.add("show");
                                        }
                                    });
                                }
                                getremovals();
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        

        <div class="tablelist">
            <table class="table table-striped" id="tablelist">
                <thead class="thead-dark">
                    <tr>
                        <th>Phone</th>
                        <th>Phone Type</th>
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                        <th>Industry</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody id="tablerows"></tbody>
            </table>
        </div>

        <script>
            var result = [];
            const baseurl = "<?php echo $baseurl ?>";
            fetchInputs = ()=>{
                const industry_search = [];
                const industry_negation_search = [];
                document.querySelector("#industry").value.toLowerCase().split(",").forEach(element => {
                    element = element.trim();
                    if (element == "") {} else if (element.startsWith("~")) {
                        industry_negation_search.push(element.slice(1));
                    } else {
                        industry_search.push(element)
                    };
                });

                const cname_search = [];
                const cname_negation_search = [];
                document.querySelector("#cname").value.toLowerCase().split(",").forEach(element => {
                    element = element.trim();
                    if (element == "") {} else if (element.startsWith("~")) {
                        cname_negation_search.push(element.slice(1));
                    } else {
                        cname_search.push(element);
                    }
                });

                const city_search = [];
                const city_negation_search = [];
                document.querySelector("#city").value.toLowerCase().split(",").forEach(element => {
                    element = element.trim();
                    if (element == "") {} else if (element.startsWith("~")) {
                        city_negation_search.push(element.slice(1));
                    } else {
                        city_search.push(element);
                    }
                });

                const stateArray = Array.from(document.querySelectorAll("#state option:checked")).map(option => option.value);
                const phonetypeArray = Array.from(document.querySelectorAll("#phonetype option:checked")).map(option => option.value);
                const categoryArray = Array.from(document.querySelectorAll("#category option:checked")).map(option => option.value);

                const formData = new FormData();
                formData.append("industry_search", industry_search);
                formData.append("industry_negation_search", industry_negation_search);
                formData.append("cname_search", cname_search);
                formData.append("cname_negation_search", cname_negation_search);
                formData.append("city_search", city_search);
                formData.append("city_negation_search", city_negation_search);
                formData.append("state", stateArray.join(","));
                formData.append("phonetype", phonetypeArray.join(","));
                formData.append("category", categoryArray.join(","));
                formData.append("jwt", window.localStorage.getItem("jwt"));

                return formData;
            }

            document.querySelector("#industry-btn").addEventListener("click", (e) => {
                const formData = fetchInputs();

                document.querySelector("body").classList.toggle("loading");

                timer.timestart();
                const response = fetch(baseurl + "backend/search.php", {
                    method: "POST",
                    body: formData,
                });

                response.then((res) => res.json())
                .then((payload) => {
                    document.querySelector("body").classList.toggle("loading");
                    result = payload.data;
                    payload.count==0?document.getElementById('downloadable').setAttribute("disabled", "disabled"):document.getElementById('downloadable').removeAttribute("disabled");
                    document.getElementById("show_count").innerHTML = payload.count;
                    let rows = "";
                    payload.data.forEach((entry) => {
                        rows += `<tr><td>${entry.phone}</td><td>${entry.phonetype}</td><td>${entry.companyname}</td><td>${entry.address}</td><td>${entry.city}</td><td>${entry.state}</td><td>${entry.zip}</td><td>${entry.industry}</td><td>${entry.category}</td></tr>`;
                    });
                    document.getElementById('tablerows').innerHTML = rows;
                    timer.timestop()
                })
                .catch((error) => {
                    console.error('Error fetching data:', error);
                    document.querySelector(".footer").innerHTML=`Something is wrong. Server might down. Please contact Akila unless the website cannot be reloaded.`;
                });
            });

            document.querySelector("#count-btn").addEventListener("click", (e) => {
                const formData = fetchInputs();

                document.querySelector("body").classList.toggle("loading");

                timer.timestart();
                const response = fetch(baseurl + "backend/getcount.php", {
                    method: "POST",
                    body: formData,
                });

                response.then((res) => res.json())
                .then((payload) => {
                    document.querySelector("body").classList.toggle("loading");
                    result = payload.data;
                    
                    document.getElementById("show_count").innerHTML = payload.count;
                    let rows = "";
                    payload.data.forEach((entry) => {
                        rows += `<tr><td>${entry.phone}</td><td>${entry.phonetype}</td><td>${entry.companyname}</td><td>${entry.address}</td><td>${entry.city}</td><td>${entry.state}</td><td>${entry.zip}</td><td>${entry.industry}</td><td>${entry.category}</td></tr>`;
                    });
                    document.getElementById('tablerows').innerHTML = rows;
                    timer.timestop()
                })
                .catch((error) => {
                    console.error('Error fetching data:', error);
                    document.querySelector(".footer").innerHTML=`Something is wrong. Server might down. Please contact Akila unless the website cannot be reloaded.`;
                });
            });
        </script>

        <script>
            // Function to download the CSV file
            const download = (data) => {
                // Create a Blob with the CSV data and type
                const blob = new Blob([data], { type: 'text/csv' });
                
                // Create a URL for the Blob
                const url = URL.createObjectURL(blob);
                
                // Create an anchor tag for downloading
                const a = document.createElement('a');
                
                // Set the URL and download attribute of the anchor tag
                a.href = url;
                a.download = 'download.csv';
                
                // Trigger the download by clicking the anchor tag
                a.click();
            }
            const csvmaker = function (data) {
                // Empty array for storing the values
                csvRows = [];

                // Headers is basically a keys of an object which 
                // is id, name, and profession
                const headers = Object.keys(data[0]);

                // As for making csv format, headers must be
                // separated by comma and pushing it into array
                csvRows.push(headers.join(','));

                // Pushing Object values into the array with
                // comma separation

                // Looping through the data values and make
                // sure to align values with respect to headers
                for (const row of data) {
                    const values = headers.map(e => {
                        return row[e]
                    })
                    csvRows.push(values.join(','))
                }

                // returning the array joining with new line 
                return csvRows.join('\n')
            }
            // Asynchronous function to fetch data and download the CSV file
            const get = async () => {
                // Create the CSV string from the data
                const csvdata = csvmaker(result);
                
                // Download the CSV file
                download(csvdata);
            }
            // Add a click event listener to the button with ID 'action'
            document.getElementById('save').addEventListener('click', get);
        </script>

    </body>
</html>