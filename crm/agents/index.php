<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.shopify.com/s/files/1/0027/0578/4877/files/jquery.datetimepicker.min.css?v=1730216903" />
  
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.shopify.com/s/files/1/0027/0578/4877/files/jquery.datetimepicker.full.min.js?v=1730216904"></script>
    <script src="https://cdn.shopify.com/s/files/1/0027/0578/4877/files/moment.js?v=1730218704"></script>

    <style>
        .hide { display: none; }
        .xdsoft_datetimepicker .xdsoft_timepicker { margin-left: 16px!important; }
        body {
            font-size: 17px;
        }
    </style>
</head>
<body>
    <?php
        require_once '../backend/constant.php';
        require_once '../components/getAuthenticated.php';
        require_once '../components/loader.php';
    ?>

    <script>
        const r = window.sessionStorage.getItem("r");
        if (r==="o"){
            window.location.replace("<?php echo $baseurl ?>admin/"); 
        }

        const playsound = ()=>{
            const audio = new Audio("https://cdn.shopify.com/s/files/1/0027/0578/4877/files/ring.mp3?v=1733065254");
            audio.loop = true;
            audio.play().catch(error => console.error("Playback failed:", error));
        }
    </script>

    <div style="position: fixed; right: 0; top: 0;">
        <div class="d-flex align-items-center">
            <div class="company-name me-2" style="text-transform: capitalize;"></div>-<button class="btn btn-link" onclick="logout()">logout</button>
        </div>
    </div>
    <script>
        document.querySelector(".company-name").innerHTML = window.sessionStorage.getItem("cname");
    </script>

    <div class="mx-4 mt-3">
        <div class="mt-0">
            <div class="h6 mb-1">Recommendation for No Answers</div>
            <ul class="mb-1">
                <li>1st No Answer - Leave a message, select NA1, and Add Lead.</li>
                <li>2nd No Answer - Leave a message, select NA2, and Update Lead.</li>
                <li>3rd No Answer -  Leave a message letting them know you contacted 3 times. Select Remarket, and Update Lead.</li>
            </ul>
        </div>
    </div>
    
    <div class="accordion mt-2 mx-2" id="mainaccord">

        <div class="accordion-item" id="addInfoForm">
            <div class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                    <!-- collapsed -->
                    <div class="h5">Add Lead</div>
                </button>
            </div>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" data-bs-parent="#mainaccord">
                <!-- show -->
                <form action="<?php echo $baseurl ?>agents/addInfo.php" method="post" onsubmit="addInfo(event);" class="accordion-body my-2" onchange="selfvalidate(event);">
                    <div class="row g-3 mb-3">
                        <div class="d-inline-block" style="width: 130px;">
                            <label for="phone" class="form-label">Phone 1*</label>
                            <input type="text" name="phone" id="phone" class="form-control" maxlength="20" required pattern="[0-9]{10}" onkeyup="phonenumbervalidation(event)"/>
                            <small class="form-text text-muted"></small>
                        </div>
                        <div class="d-inline-block" style="width: 130px;">
                            <label for="phone2" class="form-label">Phone 2</label>
                            <input type="text" name="phone2" id="phone2" class="form-control" maxlength="20" pattern="[0-9]{10}" onkeyup="phonenumbervalidation(event)"/>
                            <small class="form-text text-muted"></small>
                        </div>
                        <div class="d-inline-block" style="width: 300px;">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" maxlength="50"/>
                        </div>
                        <div class="d-inline-block" style="width: 300px;">
                            <label for="web" class="form-label">Website/FB</label>
                            <input type="text" name="web" id="web" class="form-control" maxlength="100"/>
                        </div>
                        <div class="d-inline-block" style="width: 300px;">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control" maxlength="100"/>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="d-inline-block" style="width: 350px;">
                            <label for="company" class="form-label">Company Name</label>
                            <input type="text" name="company" id="company" class="form-control" maxlength="50"/>
                        </div>
                        <div class="d-inline-block" style="width: 350px;">
                            <label for="name" class="form-label">Owner(s) Name(s)</label>
                            <input type="text" name="uname" id="uname" class="form-control" maxlength="50"/>
                        </div>
                        <div class="d-inline-block" style="width: 130px;">
                            <label for="revenue" class="form-label">Gross Revenue</label>
                            <input type="text" name="revenue" id="revenue" class="form-control" maxlength="50"/>
                        </div>
                        <!-- <div class="d-inline-block" style="width: 200px;">
                            <label for="aname" class="form-label">Agent Name</label>
                            <input type="text" name="aname" id="aname" class="form-control" maxlength="50"/>
                        </div> -->
                        <div class="d-inline-block" style="width: 230px;">
                            <label for="appointment" class="form-label">Appointment <span class="btn btn-link" style="padding: 0; margin-top: -6px;" onclick="dateclr();">clear</span></label>
                            <!-- <input type="datetime-local" id="appointment" name="appointment" class="form-control"/> -->
                            <input type="text" id="appointment" name="appointment" class="appointment1 form-control" autocomplete="off">
                            <div class="invalid-feedback">Please enter a future date and time.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="d-none me-4">
                                <!-- <input class="form-check-input" type="checkbox" value="" id="nocontact" name="nocontact"> -->
                                <input class="form-check-input" type="radio" name="status" id="nocontact" >
                                <label class="form-check-label" for="nocontact">
                                    No Answer
                                </label>
                            </div>
                            <div class="d-inline-block me-4">
                                <!-- <input class="form-check-input" type="checkbox" value="" id="notinterested" name="notinterested"> -->
                                <input class="form-check-input" type="radio" name="status" id="notinterested">
                                <label class="form-check-label" for="notinterested">
                                    Not Interested
                                </label>
                            </div>
                            <div class="d-inline-block me-4">
                                <!-- <input class="form-check-input" type="checkbox" value="" id="followingup" name="followingup"> -->
                                <input class="form-check-input" type="radio" name="status" id="followingup" checked>
                                <label class="form-check-label" for="followingup">
                                    Interested
                                </label>
                            </div>
                            <div class="d-inline-block me-4">
                                <!-- <input class="form-check-input" type="checkbox" value="" id="listedtosale" name="listedtosale"> -->
                                <input class="form-check-input" type="radio" name="status" id="listedtosale">
                                <label class="form-check-label" for="listedtosale">
                                    Listed
                                </label>
                            </div>
                            <div class="d-inline-block me-4">
                                <!-- <input class="form-check-input" type="checkbox" value="" id="successsale" name="successsale"> -->
                                <input class="form-check-input" type="radio" name="status" id="successsale">
                                <label class="form-check-label" for="successsale">
                                Sold
                                </label>
                            </div>
                            <div class="d-inline-block me-4">
                                <input class="form-check-input" type="checkbox" value="" id="possibleproperty" name="possibleproperty">
                                <!-- <input class="form-check-input" type="radio" name="possibletype" id="possibleproperty"> -->
                                <label class="form-check-label" for="possibleproperty">
                                    +Property Sale
                                </label>
                            </div>
                            <div class="d-inline-block me-4">
                                <input class="form-check-input" type="checkbox" value="" id="possiblebuyer" name="possiblebuyer">
                                <!-- <input class="form-check-input" type="radio" name="possibletype" id="possiblebuyer"> -->
                                <label class="form-check-label" for="possiblebuyer">
                                    +Biz Buyer
                                </label>
                            </div>
                            <div class="d-block">
                                <div class="d-inline-block me-4 mt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="na1" name="na1">
                                    <label class="form-check-label" for="na1">
                                        NA1
                                    </label>
                                </div>
                                <div class="d-inline-block me-4 mt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="na2" name="na2">
                                    <label class="form-check-label" for="na2">
                                        NA2
                                    </label>
                                </div>
                                <div class="d-inline-block me-4 mt-3">
                                    <input class="form-check-input" type="radio" name="status" id="lowrev" >
                                    <label class="form-check-label" for="lowrev">
                                        Remarket
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" row="3" class="form-control" maxlength="500"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
                <script>
                    const formatPhone = (input) => {
                        // Remove all non-digit characters
                        const digits = input.replace(/\D/g, '');
                        
                        // Apply formatting
                        let formatted = '';
                        if (digits.length > 0) {
                            formatted += '(' + digits.slice(0, 3); // Add area code
                        }
                        if (digits.length >= 4) {
                            formatted += ') ' + digits.slice(3, 6); // Add first three digits
                        }
                        if (digits.length >= 7) {
                            formatted += '-' + digits.slice(6, 10); // Add last four digits
                        }

                        // Update input value
                        return formatted;
                    }
                    const dateclr = ()=>{
                        document.querySelectorAll("#appointment").forEach((comp)=>{comp.value = "";});
                    }
                    const phonenumbervalidation = (e)=>{
                        e.target.value = e.target.value.replace(/\D/g,'');
                        if (e.target.value.length==11){ e.target.value = e.target.value.slice(1); }
                        e.target.parentElement.querySelector("small").innerHTML = formatPhone(e.target.value);
                    }
                    const getDateAfterThreeDaysExcludingWeekends = (startDate, olddatestring="")=>{
                        if (olddatestring!=""){
                            const existingDate = new Date(getfrontendtime(olddatestring));
                            const atoday = new Date();
                            if ((existingDate-atoday)/(1000*60*60)>12){
                                return existingDate;
                            }
                        }
                        let daysAdded = 0;
                        let currentDate = new Date(startDate);

                        while (daysAdded < 2) {
                            // Move to the next day
                            currentDate.setDate(currentDate.getDate() + 1);

                            // Check if the current day is a weekday (Monday to Friday)
                            const dayOfWeek = currentDate.getDay();
                            if (dayOfWeek !== 0 && dayOfWeek !== 6) { // 0 = Sunday, 6 = Saturday
                                daysAdded++;
                            }
                        }
                        currentDate.setHours(8, 0);
                        return currentDate;
                    }
                    const addInfo = (event)=>{
                        event.preventDefault();
                        const form = event.currentTarget;
                        const url = new URL(form.action);
                        const formData = new FormData(form);

                        if ((document.querySelector("#addInfoForm #nocontact").checked || document.querySelector("#addInfoForm #followingup").checked)
                        && !(document.querySelector("#addInfoForm #na1").checked || document.querySelector("#addInfoForm #na2").checked)
                        ){
                            if(!validappointment(document.querySelector("#addInfoForm #appointment").value)){
                                document.querySelector("#addInfoForm #appointment").classList.add("is-invalid");
                                return;
                            };
                        }
                        document.querySelector("#addInfoForm #appointment").classList.remove("is-invalid");

                        if (document.querySelector("#addInfoForm #na1").checked || document.querySelector("#addInfoForm #na2").checked){
                            formData.set("appointment", getDateToBackendTime(getDateAfterThreeDaysExcludingWeekends(new Date())));
                        } else {
                            formData.set("appointment", getbackendtime(loadedData.adddatetime));
                        }

                        formData.append("lowrev", document.querySelector("#addInfoForm #lowrev").checked);
                        formData.append("nocontact", document.querySelector("#addInfoForm #nocontact").checked);
                        formData.append("notinterested", document.querySelector("#addInfoForm #notinterested").checked);
                        formData.append("followingup", document.querySelector("#addInfoForm #followingup").checked);
                        formData.append("listedtosale", document.querySelector("#addInfoForm #listedtosale").checked);
                        formData.append("successsale", document.querySelector("#addInfoForm #successsale").checked);
                        formData.append("possibleproperty", document.querySelector("#addInfoForm #possibleproperty").checked);
                        formData.append("possiblebuyer", document.querySelector("#addInfoForm #possiblebuyer").checked);
                        formData.append("na1", document.querySelector("#addInfoForm #na1").checked);
                        formData.append("na2", document.querySelector("#addInfoForm #na2").checked);
                        formData.append("whocreatedpk", window.sessionStorage.getItem("ukey"));
                        formData.append("whichcompany", window.sessionStorage.getItem("cname"));
                        formData.append("jwt", window.sessionStorage.getItem("jwt"));
                        timer.timestart();
                        fetch(url, {
                            method: form.method,
                            body: formData
                        })
                        .then((response)=>response.json())
                        .then((data)=>{
                            timer.timestop();
                            if (data.success){
                                // clear fields
                                document.querySelector("#addInfoForm #email").value = "";
                                document.querySelector("#addInfoForm #phone").value = "";
                                document.querySelector("#addInfoForm #phone2").value = "";
                                document.querySelector("#addInfoForm #company").value = "";
                                document.querySelector("#addInfoForm #uname").value = "";
                                document.querySelector("#addInfoForm #web").value = "";
                                document.querySelector("#addInfoForm #address").value = "";
                                document.querySelector("#addInfoForm #revenue").value = "";
                                // document.querySelector("#addInfoForm #aname").value = "";
                                document.querySelector("#addInfoForm #appointment").value = "";
                                document.querySelector("#addInfoForm #lowrev").checked = false;
                                document.querySelector("#addInfoForm #nocontact").checked = false;
                                document.querySelector("#addInfoForm #notinterested").checked = false;
                                document.querySelector("#addInfoForm #followingup").checked = true;
                                document.querySelector("#addInfoForm #listedtosale").checked = false;
                                document.querySelector("#addInfoForm #successsale").checked = false;
                                document.querySelector("#addInfoForm #possibleproperty").checked = false;
                                document.querySelector("#addInfoForm #possiblebuyer").checked = false;
                                document.querySelector("#addInfoForm #na1").checked = false;
                                document.querySelector("#addInfoForm #na2").checked = false;
                                document.querySelector("#addInfoForm #notes").value = "";
                                listInfoAgent();
                            }else{
                                alert(data.message);
                            }
                        });
                    }
                </script>
            </div>
        </div>

        <div class="accordion-item" id="searchInfoSection">
            <div class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    <div class="h5">Edit Leads</div>
                </button>
            </div>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#mainaccord"> 
                <!-- show -->
                <div class="accordion-body">


                    <form action="<?php echo $baseurl ?>agents/updateInfo.php" method="post" onsubmit="updateInfo(event);" class="mb-5 hide" id="updateInfoForm" onchange="selfvalidate(event);">
                        <input type="text" name="pk" id="pk" hidden/>
                        <input type="text" name="oldemail" id="oldemail" hidden/>
                        <input type="text" name="oldphone" id="oldphone" hidden/>
                        <input type="text" name="oldphone2" id="oldphone2" hidden/>
                        <div class="row g-3 mb-3">
                            <div class="d-inline-block" style="width: 130px;">
                                <label for="phone" class="form-label">Phone 1*</label>
                                <input type="text" name="phone" id="phone" class="form-control" maxlength="20" required pattern="[0-9]{10}" onkeyup="phonenumbervalidation(event)"/>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="d-inline-block" style="width: 130px;">
                                <label for="phone2" class="form-label">Phone 2</label>
                                <input type="text" name="phone2" id="phone2" class="form-control" maxlength="20" pattern="[0-9]{10}" onkeyup="phonenumbervalidation(event)"/>
                                <small class="form-text text-muted"></small>
                            </div>
                            <div class="d-inline-block" style="width: 300px;">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" maxlength="50"/>
                            </div>
                            <div class="d-inline-block" style="width: 300px;">
                                <label for="web" class="form-label">Website/FB</label>
                                <input type="text" name="web" id="web" class="form-control" maxlength="100"/>
                            </div>
                            <div class="d-inline-block" style="width: 300px;">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control" maxlength="100"/>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="d-inline-block" style="width: 350px;">
                                <label for="company" class="form-label">Company Name</label>
                                <input type="text" name="company" id="company" class="form-control" maxlength="50"/>
                            </div>
                            <div class="d-inline-block" style="width: 350px;">
                                <label for="name" class="form-label">Owner(s) Name(s)</label>
                                <input type="text" name="uname" id="uname" class="form-control" maxlength="50"/>
                            </div>
                            <div class="d-inline-block" style="width: 130px;">
                                <label for="revenue" class="form-label">Gross Revenue</label>
                                <input type="text" name="revenue" id="revenue" class="form-control" maxlength="50"/>
                            </div>
                            <!-- <div class="d-inline-block" style="width: 200px;">
                                <label for="aname" class="form-label">Agent Name</label>
                                <input type="text" name="aname" id="aname" class="form-control" maxlength="50"/>
                            </div> -->
                            <div class="d-inline-block" style="width: 230px;">
                                <label for="appointment" class="form-label">Appointment <span class="btn btn-link" style="padding: 0; margin-top: -6px;" onclick="dateclr();">clear</span></label>
                                <!-- <input type="datetime-local" id="appointment" name="appointment" class="form-control"/> -->
                                <input type="text" id="appointment" name="appointment" class="appointment2 form-control" autocomplete="off">
                                <div class="invalid-feedback">Please enter a future date and time.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="d-none me-4">
                                    <!-- <input class="form-check-input" type="checkbox" value="" id="nocontactu" name="nocontact"> -->
                                    <input class="form-check-input" type="radio" name="status" id="nocontactu">
                                    <label class="form-check-label" for="nocontactu">
                                        No Answer
                                    </label>
                                </div>
                                <div class="d-inline-block me-4">
                                    <!-- <input class="form-check-input" type="checkbox" value="" id="notinterestedu" name="notinterested"> -->
                                    <input class="form-check-input" type="radio" name="status" id="notinterestedu">
                                    <label class="form-check-label" for="notinterestedu">
                                        Not Interested
                                    </label>
                                </div>
                                <div class="d-inline-block me-4">
                                    <!-- <input class="form-check-input" type="checkbox" value="" id="followingupu" name="followingup"> -->
                                    <input class="form-check-input" type="radio" name="status" id="followingupu">
                                    <label class="form-check-label" for="followingupu">
                                        Interested
                                    </label>
                                </div>
                                <div class="d-inline-block me-4">
                                    <!-- <input class="form-check-input" type="checkbox" value="" id="listedtosaleu" name="listedtosale"> -->
                                    <input class="form-check-input" type="radio" name="status" id="listedtosaleu">
                                    <label class="form-check-label" for="listedtosaleu">
                                        Listed
                                    </label>
                                </div>
                                <div class="d-inline-block me-4">
                                    <!-- <input class="form-check-input" type="checkbox" value="" id="successsaleu" name="successsale"> -->
                                    <input class="form-check-input" type="radio" name="status" id="successsaleu">
                                    <label class="form-check-label" for="successsaleu">
                                        Sold
                                    </label>
                                </div>
                                <div class="d-inline-block me-4">
                                    <input class="form-check-input" type="checkbox" value="" id="possiblepropertyu" name="possibleproperty">
                                    <!-- <input class="form-check-input" type="radio" name="possibletype" id="possiblepropertyu"> -->
                                    <label class="form-check-label" for="possiblepropertyu">
                                        +Property Sale
                                    </label>
                                </div>
                                <div class="d-inline-block me-4">
                                    <input class="form-check-input" type="checkbox" value="" id="possiblebuyeru" name="possiblebuyer">
                                    <!-- <input class="form-check-input" type="radio" name="possibletype" id="possiblebuyeru"> -->
                                    <label class="form-check-label" for="possiblebuyeru">
                                        +Biz Buyer
                                    </label>
                                </div>
                                <div class="d-block">
                                    <div class="d-inline-block me-4 mt-3">
                                        <input class="form-check-input" type="checkbox" value="" id="na1u" name="na1">
                                        <label class="form-check-label" for="na1u">
                                            NA1
                                        </label>
                                    </div>
                                    <div class="d-inline-block me-4 mt-3">
                                        <input class="form-check-input" type="checkbox" value="" id="na2u" name="na2">
                                        <label class="form-check-label" for="na2u">
                                            NA2
                                        </label>
                                    </div>
                                    <div class="d-inline-block me-4 mt-3">
                                        <input class="form-check-input" type="radio" name="status" id="lowrevu">
                                        <label class="form-check-label" for="lowrevu">
                                            Remarket
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" row="3" class="form-control" maxlength="500"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" onclick="cancelEdit();">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                    </form>


                    <div class="mb-5">
                        <table class="data-table table table-striped table-bordered desktop-data" data-page-length='1000'>
                            <thead>
                                <tr>
                                    <th scope="col">Company</th>
                                    <th scope="col">Owner</th>
                                    <th scope="col">Revenue</th>
                                    <th scope="col">Agent</th>
                                    <th scope="col">Email</th>
                                    <!-- <th scope="col">Web/FB</th> -->
                                    <th scope="col">Phone</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col">Appointment</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tfoot class="filters" style="display: table-header-group;">
                                <tr>
                                    <th><input type="text" name="company" id="company-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th><input type="text" name="uname" id="uname-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th><input type="text" name="revenue" id="revenue-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th><input type="text" name="username" id="username-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th><input type="text" name="email" id="email-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th style="display:none;"><input type="text" name="web" id="web-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th><input type="text" name="phone" id="phone-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th><input type="text" name="notes" id="notes-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th><input type="text" name="appointment" id="appointment-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th><input type="text" name="status" id="status-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th><input type="text" name="pmode" id="pmode-input" autocomplete="off" onkeydown="searchInfo(event)"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>

                        <div class="data-list mobile-data">
                            
                            <div class="filters">
                                <div style="font-weight: 600; margin-bottom: 5px; font-size: 15px;">
                                    Filters
                                </div>
                                <input type="text" placeholder="Company" name="company" id="company-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input type="text" placeholder="Owner" name="uname" id="uname-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input hidden type="text" placeholder="Revenue" name="revenue" id="revenue-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input type="text" placeholder="Agent" name="username" id="username-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input hidden type="text" placeholder="Email" name="email" id="email-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input hidden type="text" placeholder="Web/Fb" name="web" id="web-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input hidden type="text" placeholder="Phone" name="phone" id="phone-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input hidden type="text" placeholder="Notes" name="notes" id="notes-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input hidden type="text" placeholder="Appointment" name="appointment" id="appointment-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input hidden type="text" placeholder="Status" name="status" id="status-input" autocomplete="off" onkeydown="searchInfo(event)">
                                <input hidden type="text" placeholder="Mode" name="pmode" id="pmode-input" autocomplete="off" onkeydown="searchInfo(event)">
                            </div>
                            <div class="showcase">
                            </div>
                        </div>

                        <div class="my-3">
                        </div>

                        <button class="btn btn-primary desktop" onclick="download();">Download</button>
                    </div>

                    <style>
                        /* mobile view */
                        .mobile-data .filters { margin-bottom: 10px; }
                        .mobile-data .filters input { width: 49%; }
                        .showcase { border: solid 1px #cdc9c9; margin: 0 -21px; }
                        .showcase .accord-head:nth-child(2n) { background-color: #f3f2f2; }
                        .showcase .accord-head.green { background-color: #ccffcc!important;}
                        .showcase .accord-head.red { background-color: #ffcccc!important;}
                        .accord-head { cursor: pointer; display: flex; justify-content: space-between; align-items: center; border-bottom: solid 1px #cdc9c9; padding: 6px 4px; }
                        .accord-head > div { display: flex; align-items: center; }
                        /* .accord-head > div > div:nth-child(1) {} */
                        /* .accord-show .accord-head > div > div:nth-child(1) { transform: rotate(180deg) translateX(25%); } */
                        .accord-head > div > div:nth-child(2) div { display: inline-block;  }
                        .accord-hide .accord { display: none; }
                        .accord-show .accord { display: block; }
                        .accord { padding: 5px 10px 10px 10px; }
                        .accord span { background-color: #beffc9; border-radius: 5px; margin-right: 5px; padding: 0 4px; }
                        .accord span.badge { padding: 0.35em 0.35em; }
                    </style>
                    <style>
                        table.data-table  > tfoot > tr > th, table.data-table  > tfoot > tr > td { padding: 6px 2px!important; }
                        table.data-table  > thead > tr > th, table.data-table  > thead > tr > td { padding: 2px!important; }
                        table.data-table tr.green td { background-color: #ccffcc!important;}
                        table.data-table tr.red td { background-color: #ffcccc!important;}
                        table.data-table > tbody td { padding: 0 0 0 6px; }
                        table.data-table  > tfoot input { width: 100%; }
                        .desktop-data { display: none!important; }
                        @media (min-width: 1260px) {
                            .desktop-data { display: table!important; }
                            .mobile-data { display: none!important; }
                        }
                    </style>

                    <script>
                        const opencloseaccord = (e)=>{
                            const record = e.target.closest(".accord-head").parentElement;
                            if (record.classList.contains("accord-hide")){
                                record.classList.remove("accord-hide"); record.classList.add("accord-show");
                            } else {
                                record.classList.add("accord-hide"); record.classList.remove("accord-show");
                            };
                        }
                    </script>

                    <script>
                        const loadedData = {};
                        loadedData.notificationCountdown = null;
                        loadedData.filteredData = [];

                        loadedData.mobileItemPlaceholder = { "fullItem": `<div class="accord-i accord-hide">
                                    <div class="accord-head _TENSE_" onclick="opencloseaccord(event);">
                                        <div>
                                            <div></div>
                                            <div>
                                                _HEAD-PLACE_
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accord">
                                        _ITEM-PLACE_
                                    </div>
                                </div>`,
                                "itemHead": `<div>_OWNER_</div><div>_COMPANY_</div><div><a style="text-wrap-mode: nowrap;" href="tel:+1_PHONE1_">_PHONE1-FORMAT_</a></div>`,
                                "phone": `<div><span>Phone: </span><a style="text-wrap-mode: nowrap;" href="tel:+1_PHONE2_">_PHONE2-FORMAT_</a></div>`,
                                "revenue": `<div><span>Rev: </span>_REV_</div>`,
                                "agent": `<div><span>Agent: </span>_AGENT_</div>`,
                                "email": `<div><span>Email: </span>_EMAIL_</div>`,
                                "web": `<div><span>Web: </span>_WEB_</div>`,
                                "status": `<div><span>Status: </span>_STATUS_</div>`,
                                "mode": `<div><span>Mode: </span>_MODE_</div>`,
                                "appointment": `<div><span>Appt: </span>_APPT_</div>`,
                                "notes": `<div>_NOTES_</div>`,
                                "button": `_EDITBTN_`

                        };
                        const cancelEdit = ()=>{
                            document.querySelector("#updateInfoForm").classList.add("hide");
                        }
                        const editButtonHandler = (event)=>{
                            loadedData.selectedToEdit = event.target.getAttribute("data-index");
                            const record = loadedData.data[event.target.getAttribute("data-index")]; 
                            document.querySelector("#updateInfoForm #pk").value = record.pk;
                            document.querySelector("#updateInfoForm #oldemail").value = record.email;
                            document.querySelector("#updateInfoForm #oldphone").value = record.phone;
                            document.querySelector("#updateInfoForm #oldphone2").value = record.phone2;
                            document.querySelector("#updateInfoForm #email").value = record.email;
                            document.querySelector("#updateInfoForm #phone").value = record.phone;
                            document.querySelector("#updateInfoForm #phone2").value = record.phone2;
                            document.querySelector("#updateInfoForm #company").value = record.company;
                            document.querySelector("#updateInfoForm #uname").value = record.uname;
                            document.querySelector("#updateInfoForm #web").value = record.web;
                            document.querySelector("#updateInfoForm #address").value = record.address;
                            document.querySelector("#updateInfoForm #revenue").value = record.revenue;
                            // document.querySelector("#updateInfoForm #aname").value = record.aname;

                            if(checkpastdate(record.appointment.replaceAll(" ", "T"))){
                                document.querySelector("#updateInfoForm #appointment").value = ""
                            }else{
                                document.querySelector("#updateInfoForm #appointment").value = getfrontendtime(record.appointment.replaceAll(" ", "T"));
                            }

                            document.querySelector("#updateInfoForm #lowrevu").checked = record.lowrev==="f"?false:true;
                            document.querySelector("#updateInfoForm #nocontactu").checked = record.nocontact==="f"?false:true;
                            document.querySelector("#updateInfoForm #notinterestedu").checked = record.notinterested==="f"?false:true;
                            document.querySelector("#updateInfoForm #followingupu").checked = record.followingup==="f"?false:true;
                            document.querySelector("#updateInfoForm #listedtosaleu").checked = record.listedtosale==="f"?false:true;
                            document.querySelector("#updateInfoForm #successsaleu").checked = record.successsale==="f"?false:true;
                            document.querySelector("#updateInfoForm #possiblepropertyu").checked = record.possibleproperty==="f"?false:true;
                            document.querySelector("#updateInfoForm #possiblebuyeru").checked = record.possiblebuyer==="f"?false:true;
                            document.querySelector("#updateInfoForm #na1u").checked = record.na1==="f"?false:true;
                            document.querySelector("#updateInfoForm #na2u").checked = record.na2==="f"?false:true;
                            document.querySelector("#updateInfoForm #notes").value = record.notes;
                            document.querySelector("#updateInfoForm").dispatchEvent(new Event('change', {bubbles: true, cancelable: true}));
                            document.querySelector("#updateInfoForm").classList.remove("hide");
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                        const formatphonenumber = (number)=>{
                            if (number==""){ return ""; }
                            return `${number.slice(0,3)}-${number.slice(3,6)}-${number.slice(6,10)}`;
                        }
                        const isMobileDevice = () => {
                            return /Mobi|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i.test(navigator.userAgent);
                        }
                        const populateSearchResult = (data)=>{
                            today = new Date();
                            data.forEach((record, i) => {
                                remaining = "9999999.999";
                                istoday = false;
                                if (record.appointment!=""){
                                    appo = new Date(Date.parse(record.appointment));
                                    istoday = appo.getDate() == today.getDate();
                                    remaining = (appo-today)/(1000);
                                }

                                statusArray = [];
                                if (record.notinterested==="t"){statusArray.push('<span class="badge text-bg-dark">NI</span>');}
                                if (record.followingup==="t"){statusArray.push('<span class="badge text-bg-success">Interested</span>');}
                                if (record.listedtosale==="t"){statusArray.push('<span class="badge text-bg-secondary">Listed</span>');}
                                if (record.successsale==="t"){statusArray.push('<span class="badge text-bg-info">Sold</span>');}
                                if (record.lowrev==="t"){statusArray.push('<span class="badge text-bg-warning">Remarket</span>');}
                                statusCol = "";
                                statusArray.forEach((s)=>{ statusCol += s; });
                                record.status = statusCol;

                                pmode = [];
                                if (record.possibleproperty==="t"){pmode.push('<span class="badge text-bg-warning">PropertySale</span>');}
                                if (record.possiblebuyer==="t"){pmode.push('<span class="badge text-bg-info">BizBuyer</span>');}
                                pmodeCol = "";
                                pmode.forEach((m)=>{ pmodeCol += m; });
                                record.pmode = pmodeCol;

                                record.fullphone = `${formatphonenumber(record.phone)} ${formatphonenumber(record.phone2)} ${record.phone} ${record.phone2}`;
                                
                                // Not Interested
                                if (record.notinterested==="t"){ remaining = 999999990; }

                                // Listed
                                if (record.listedtosale=="t"){ remaining = 999999991; }

                                // Sold
                                if (record.successsale=="t"){ remaining = 999999992; }

                                // Remarket
                                if (record.lowrev==="t"){ remaining = 999999993; }

                                // +Biz Buyer
                                if (record.possiblebuyer=="t"){ remaining = 999999994; }

                                record.priority = remaining;
                                record.istoday = istoday;

                                if (record.editbtn){}else{
                                    record.editbtn = `<button class="btn btn-primary btn-sm" data-index="${i}" data-key="${record.pk}" onclick="editButtonHandler(event);">EDIT</button>`;
                                }
                            });
                            sorteddata = [...data];
                            sorteddata = sorteddata.sort((a, b) => {
                                if (a.priority < b.priority) return -1; 
                                if (a.priority > b.priority) return 1;
                                return 0;
                            });
                            loadedData.filteredData = sorteddata;   

                            // display the items
                            if (loadedData.device == ".desktop-data"){
                                const tableEle = document.querySelector("#searchInfoSection table tbody");
                                tableEle.innerHTML = "";
                                sorteddata.forEach((record, i) => {
                                    if (loadedData.notificationCountdown==null){
                                        if (record.priority>=0){
                                            if (record.priority<999999980){
                                                loadedData.notificationCountdown = window.setTimeout(()=>{ playsound(); }, record.priority*1000);
                                            }
                                        }
                                    }
                                    tense = "";
                                    if (record.priority<0){ tense = "class='red'"; } else if (record.istoday && record.priority<(24*60*60)){ tense="class='green'"; } else { tense=""; }
                                    tableEle.innerHTML += `<tr ${tense}>
                                    <td>${record.company}</td>
                                    <td>${record.uname}</td>
                                    <td>${record.revenue}</td>
                                    <td>${record.username}</td>
                                    <td><a href= "mailto: ${record.email}">${record.email}</a></td>
                                    <td><a style="text-wrap-mode: nowrap;" href="tel:+1${record.phone}">${formatphonenumber(record.phone)}</a>, <a style="text-wrap-mode: nowrap;" href="tel:+1${record.phone2}">${formatphonenumber(record.phone2)}</a>
                                    <div class="d-none">${record.phone} ${record.phone2}</div>
                                    </td>
                                    <td>${record.na1=="t"?`<span class="badge text-bg-warning">NA1</span> `:""}${record.na2=="t"?`<span class="badge text-bg-warning">NA2</span> `:""}${record.notes}</td>
                                    <td>${getfrontendtime(record.appointment)}</td>
                                    <td>${record.status}</td>
                                    <td>${record.pmode}</td>
                                    <td>${record.editbtn}</td>
                                    </tr>`;
                                });
                            } else if (loadedData.device == ".mobile-data"){
                                const divEle = document.querySelector(".mobile-data .showcase");
                                divEle.innerHTML = "";

                                // let's populate items step by step
                                const step = 3; 
                                items = "";
                                sorteddata.forEach((record, i)=>{
                                    if (loadedData.notificationCountdown==null){
                                        if (record.priority>=0){
                                            if (record.priority<999999980){
                                                loadedData.notificationCountdown = window.setTimeout(()=>{ playsound(); }, record.priority*1000);
                                            }
                                        }
                                    }
                                    tense = "";
                                    if (record.priority<0){ tense = "red"; } else if (record.istoday && record.priority<(24*60*60)){ tense="green"; } else { tense=""; }
                                    itemplaceholder = String(loadedData.mobileItemPlaceholder['fullItem']);
                                    
                                    itemplaceholder = itemplaceholder.replace("_TENSE_", tense);

                                    itemhead = String(loadedData.mobileItemPlaceholder['itemHead']);
                                    itemhead = itemhead.replace("_OWNER_", record.uname!=""?`${record.uname},&nbsp;`:"")
                                    itemhead = itemhead.replace("_COMPANY_", record.company!=""?`${record.company},&nbsp;`:"")
                                    itemhead = itemhead.replace("_PHONE1_", record.phone)
                                    itemhead = itemhead.replace("_PHONE1-FORMAT_", formatphonenumber(record.phone))

                                    itemplaceholder = itemplaceholder.replace("_HEAD-PLACE_", itemhead);

                                    itembody = "";
                                    if (record.phone2 != "") { itembody += String(loadedData.mobileItemPlaceholder['phone']).replace("_PHONE2_", record.phone2).replace("_PHONE2-FORMAT_", formatphonenumber(record.phone2)); }
                                    if (record.revenue != "") { itembody += String(loadedData.mobileItemPlaceholder['revenue']).replace("_REV_", record.revenue); }
                                    if (record.username != "") { itembody += String(loadedData.mobileItemPlaceholder['agent']).replace("_AGENT_", record.username); }
                                    if (record.email != "") { itembody += String(loadedData.mobileItemPlaceholder['email']).replace("_EMAIL_", `<a href= "mailto: ${record.email}">${record.email}</a>`); }
                                    if (record.web != "") { itembody += String(loadedData.mobileItemPlaceholder['web']).replace("_WEB_", record.web); }
                                    if (record.status != "") { itembody += String(loadedData.mobileItemPlaceholder['status']).replace("_STATUS_", record.status); }
                                    if (record.pmode != "") { itembody += String(loadedData.mobileItemPlaceholder['mode']).replace("_MODE_", record.pmode); }
                                    if (record.appointment != "") { itembody += String(loadedData.mobileItemPlaceholder['appointment']).replace("_APPT_", record.appointment); }
                                    if (record.notes != "") { itembody += String(loadedData.mobileItemPlaceholder['notes']).replace("_NOTES_", 
                                        `${record.na1=="t"?`<span class="badge text-bg-warning">NA1</span> `:""}${record.na2=="t"?`<span class="badge text-bg-warning">NA2</span> `:""}${record.notes}`); }
                                    itembody += String(loadedData.mobileItemPlaceholder['button']).replace("_EDITBTN_", record.editbtn);

                                    itemplaceholder = itemplaceholder.replace("_ITEM-PLACE_", itembody);
                                    
                                    items += itemplaceholder;

                                    if (i%step==0){
                                        // populate data
                                        divEle.innerHTML += items;
                                        items = "";
                                    }
                                });
                                divEle.innerHTML += items;
                            }
                        }
                        const filterObjects = (list, filters) => {
                            return list.filter(item => {
                                // Check if every non-empty filter matches the corresponding item attribute
                                return Object.keys(filters).every(key => {
                                    const filterValue = filters[key];
                                    if (filterValue === "") return true; // Ignore empty filters
                                    if (item[key] === undefined) return false; // Skip if key doesn't exist in object
                                    return item[key].toString().toLowerCase().includes(filterValue.toString().toLowerCase());
                                });
                            });
                        }
                        const searchInfo = (e)=>{
                            try {window.clearTimeout(loadedData.debouncesearch)}catch{}
                            loadedData.debouncesearch = window.setTimeout(()=>{
                                const searchparam = {
                                    company: document.querySelector(loadedData.device+" .filters input#company-input").value,
                                    uname: document.querySelector(loadedData.device+" .filters input#uname-input").value,
                                    revenue: document.querySelector(loadedData.device+" .filters input#revenue-input").value,
                                    username: document.querySelector(loadedData.device+" .filters input#username-input").value,
                                    email: document.querySelector(loadedData.device+" .filters input#email-input").value,
                                    web: document.querySelector(loadedData.device+" .filters input#web-input").value,
                                    fullphone: document.querySelector(loadedData.device+" .filters input#phone-input").value,
                                    notes: document.querySelector(loadedData.device+" .filters input#notes-input").value,
                                    appointment: document.querySelector(loadedData.device+" .filters input#appointment-input").value,
                                    status: document.querySelector(loadedData.device+" .filters input#status-input").value,
                                    pmode: document.querySelector(loadedData.device+" .filters input#pmode-input").value,
                                }
                                filteredData = filterObjects(loadedData.data, searchparam);
                                populateSearchResult(filteredData);
                            }, 1000);
                        }
                        const updateInfo = (event)=>{
                            event.preventDefault();
                            const form = event.currentTarget;
                            const url = new URL(form.action);
                            const formData = new FormData(form);

                            if ((document.querySelector("#updateInfoForm #nocontactu").checked || document.querySelector("#updateInfoForm #followingupu").checked) 
                            && !(document.querySelector("#updateInfoForm #na1u").checked || document.querySelector("#updateInfoForm #na2u").checked)
                            ){
                                if(!validappointment(document.querySelector("#updateInfoForm #appointment").value)){
                                    document.querySelector("#updateInfoForm #appointment").classList.add("is-invalid");
                                    return;
                                };
                            }
                            document.querySelector("#updateInfoForm #appointment").classList.remove("is-invalid");

                            if (document.querySelector("#updateInfoForm #na1u").checked || document.querySelector("#updateInfoForm #na2u").checked){
                                const newdate = getDateAfterThreeDaysExcludingWeekends(new Date(), loadedData.data[loadedData.selectedToEdit].appointment);
                                document.querySelector("#updateInfoForm #appointment").value = getfrontendtime(getDateToBackendTime(newdate).replaceAll("T", " "));
                                formData.set("appointment", getDateToBackendTime(newdate));
                            } else {
                                formData.set("appointment", getbackendtime(loadedData.updatedatetime));
                            }
                            
                            formData.append("lowrev", document.querySelector("#updateInfoForm #lowrevu").checked);
                            formData.append("nocontact", document.querySelector("#updateInfoForm #nocontactu").checked);
                            formData.append("notinterested", document.querySelector("#updateInfoForm #notinterestedu").checked);
                            formData.append("followingup", document.querySelector("#updateInfoForm #followingupu").checked);
                            formData.append("listedtosale", document.querySelector("#updateInfoForm #listedtosaleu").checked);
                            formData.append("successsale", document.querySelector("#updateInfoForm #successsaleu").checked);
                            formData.append("possibleproperty", document.querySelector("#updateInfoForm #possiblepropertyu").checked);
                            formData.append("possiblebuyer", document.querySelector("#updateInfoForm #possiblebuyeru").checked);
                            formData.append("na1", document.querySelector("#updateInfoForm #na1u").checked);
                            formData.append("na2", document.querySelector("#updateInfoForm #na2u").checked);
                            formData.append("whichcompany", window.sessionStorage.getItem("cname"));
                            formData.append("jwt", window.sessionStorage.getItem("jwt"));
                            timer.timestart();
                            fetch(url, {
                                method: form.method,
                                body: formData
                            })
                            .then((response)=>response.json())
                            .then((data)=>{
                                timer.timestop();
                                if (data.success){
                                    document.querySelector("#updateInfoForm").classList.add("hide");
                                    const record = {...loadedData.data[loadedData.selectedToEdit]};
                                    record.email = document.querySelector("#updateInfoForm #email").value;
                                    record.phone = document.querySelector("#updateInfoForm #phone").value;
                                    record.phone2 = document.querySelector("#updateInfoForm #phone2").value;
                                    record.company = document.querySelector("#updateInfoForm #company").value;
                                    record.uname = document.querySelector("#updateInfoForm #uname").value;
                                    record.web = document.querySelector("#updateInfoForm #web").value;
                                    record.address = document.querySelector("#updateInfoForm #address").value; 
                                    record.revenue = document.querySelector("#updateInfoForm #revenue").value; 
                                    // record.aname = document.querySelector("#updateInfoForm #aname").value;
                                    record.appointment = getbackendtime(loadedData.updatedatetime).replace("T", " ");
                                    record.lowrev = document.querySelector("#updateInfoForm #lowrevu").checked?"t":"f";
                                    record.nocontact = document.querySelector("#updateInfoForm #nocontactu").checked?"t":"f";
                                    record.notinterested = document.querySelector("#updateInfoForm #notinterestedu").checked?"t":"f";
                                    record.followingup = document.querySelector("#updateInfoForm #followingupu").checked?"t":"f";
                                    record.listedtosale = document.querySelector("#updateInfoForm #listedtosaleu").checked?"t":"f";
                                    record.successsale = document.querySelector("#updateInfoForm #successsaleu").checked?"t":"f";
                                    record.possibleproperty = document.querySelector("#updateInfoForm #possiblepropertyu").checked?"t":"f";
                                    record.possiblebuyer = document.querySelector("#updateInfoForm #possiblebuyeru").checked?"t":"f";
                                    record.na1 = document.querySelector("#updateInfoForm #na1u").checked?"t":"f";
                                    record.na2 = document.querySelector("#updateInfoForm #na2u").checked?"t":"f";
                                    record.notes = document.querySelector("#updateInfoForm #notes").value;
                                    loadedData.data[loadedData.selectedToEdit] = record;

                                    // clear search params
                                    document.querySelector(loadedData.device+" .filters input#company-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#uname-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#revenue-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#username-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#email-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#web-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#phone-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#notes-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#appointment-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#status-input").value = "";
                                    document.querySelector(loadedData.device+" .filters input#pmode-input").value = "";

                                    populateSearchResult(loadedData.data);
                                }else{
                                    alert(data.message);
                                }
                                
                            });
                        }
                        const listInfoAgent = ()=>{
                            const formData = new FormData();
                            formData.append("whichcompany", window.sessionStorage.getItem("cname"));
                            formData.append("ukey", window.sessionStorage.getItem("ukey"));
                            formData.append("jwt", window.sessionStorage.getItem("jwt"));

                            timer.timestart();

                            fetch("<?php echo $baseurl ?>agents/listInfoAgent.php", {
                                method: "post",
                                body: formData
                            })
                            .then((response)=>response.json())
                            .then((data)=>{
                                timer.timestop();
                                if (data.success){
                                    loadedData.data = data.data;
                                    populateSearchResult(data.data);
                                }
                            });
                        }
                        const getpkfromstringhtml = (htmlString) => {
                            const match = htmlString.match(/data-key="(\d+)"/);
                            return match ? match[1] : null;
                        }
                        const findObjectByPk = (objectsArray, pkValue) => {
                            return objectsArray.find(obj => obj.pk === pkValue);
                        }
                        const download = ()=>{
                            let csvContent = "data:text/csv;charset=utf-8,";

                            // clean the search array
                            const cleanData = [[
                                "Company", "Owner", "Revenue", "Agent", "Email", "Web/FB", "Phone", "Notes", "Appointment", "Not Interested", "Interested",
                                "Listed", "Sold", "Remarket", "PProperty", "PBuyer"
                            ]];
                            loadedData.filteredData.forEach(function(object) {
                                cleanData.push([
                                    object.company, object.uname, object.revenue, object.username, object.email, object.web, object.phone + " - " + object.phone2,
                                    object.notes.replaceAll("\r\n", "\t").replaceAll("#", "No:"), object.appointment, 
                                    object.notinterested=="t"?"True":"False", object.followingup=="t"?"True":"False", object.listedtosale=="t"?"True":"False", 
                                    object.successsale=="t"?"True":"False", object.lowrev=="t"?"True":"False", object.possibleproperty=="t"?"True":"False", 
                                    object.possiblebuyer=="t"?"True":"False"
                                ]);
                            });
                            cleanData.forEach(function(rowArray) {
                                let row = rowArray.join("|");
                                row = row.replaceAll(",", " - ");
                                row = row.replaceAll("|", ",");
                                csvContent += row + "\r\n";
                            });
                            var encodedUri = encodeURI(csvContent);
                            var link = document.createElement("a");
                            link.setAttribute("href", encodedUri);
                            link.setAttribute("download", "result.csv");
                            document.body.appendChild(link); // Required for FF

                            link.click()
                        }

                        const initDateTimePickers = ()=>{
                            $.datetimepicker.setDateFormatter({
                                parseDate: function (date, format) {
                                    var d = moment(date, format);
                                    return d.isValid() ? d.toDate() : false;
                                },

                                formatDate: function (date, format) {
                                    return moment(date).format(format);
                                },
                                //Optional if using mask input
                                formatMask: function(format){
                                    return format
                                        .replace(/Y{4}/g, '9999')
                                        .replace(/Y{2}/g, '99')
                                        .replace(/M{2}/g, '19')
                                        .replace(/D{2}/g, '39')
                                        .replace(/H{2}/g, '29')
                                        .replace(/m{2}/g, '59')
                                        .replace(/s{2}/g, '59');
                                }
                            });
                            loadedData.adddatetime = jQuery('.appointment1').datetimepicker({
                                format:'YYYY-MM-DD h:mm a',
                                formatTime: "h:mm a",
                                formatDate:'YYYY-MM-DD',
                                step: 15,
                                minTime: '07:00',
                                maxTime: '20:01'
                            });
                            loadedData.updatedatetime = jQuery('.appointment2').datetimepicker({
                                format:'YYYY-MM-DD h:mm a',
                                formatTime: "h:mm a",
                                formatDate:'YYYY-MM-DD',
                                step: 15,
                                minTime: '07:00',
                                maxTime: '20:01'
                            });
                            $.datetimepicker.setDateFormatter('moment');
                        }
                        const addleadingzeros = (num)=>{
                            return num<10? '0'+num:''+num;
                        }
                        const getDateToBackendTime = (date)=>{
                            a = date;
                            return `${a.getFullYear()}-${addleadingzeros(a.getMonth()+1)}-${addleadingzeros(a.getDate())}T${addleadingzeros(a.getHours())}:${addleadingzeros(a.getMinutes())}`
                        }
                        const getbackendtime = (picker)=>{
                            // Y-m-dTH:i
                            if (picker.val()==""){ return ""; }
                            a = new Date(picker.val());
                            return `${a.getFullYear()}-${addleadingzeros(a.getMonth()+1)}-${addleadingzeros(a.getDate())}T${addleadingzeros(a.getHours())}:${addleadingzeros(a.getMinutes())}`
                        }
                        const checkpastdate = (datestring)=>{
                            // Y-m-d H:i -> true false
                            if (datestring==""){ return true; }
                            atoday = new Date();
                            a = new Date(datestring);
                            if (atoday>a){return true;}else{return false;}
                        }
                        const getfrontendtime = (datestring)=>{
                            // Y-m-d H:i -> Y-m-d h:mm a
                            if (datestring==""){ return ""; }
                            a = new Date(datestring);
                            [d, t, s] = a.toLocaleString().split(" ");
                            return a.toISOString().slice(0, 10) + " " + t.slice(0, -3) + " " + s.toLowerCase();
                        }
                        const validappointment = (datetimefrontendstring)=>{
                            if (datetimefrontendstring=="") { return false; }
                            a = new Date(datetimefrontendstring);
                            b = new Date();
                            return a>b;
                        }
                        const selfvalidate = (e)=>{
                            const form = e.target.closest("form");
                            if (form.querySelector("input[id*='nocontact']").checked || form.querySelector("input[id*='followingup']").checked){
                                const appointmentComp= form.querySelector("input[id*='appointment']");
                                if(!validappointment(appointmentComp.value)){
                                    appointmentComp.classList.add("is-invalid");
                                } else {
                                    appointmentComp.classList.remove("is-invalid");
                                }
                            } else {
                                form.querySelector("input[id*='appointment']").classList.remove("is-invalid");
                            }
                            if (form.querySelector("input[id*='na1']").checked || form.querySelector("input[id*='na2']").checked){
                                form.querySelector("input[id*='appointment']").classList.remove("is-invalid");
                                form.querySelector("input[id*='appointment']").setAttribute('disabled', 'disabled');
                            } else {
                                form.querySelector("input[id*='appointment']").removeAttribute('disabled');
                            }
                            if (form.querySelector("input[id*='notinterested']").checked || form.querySelector("input[id*='listedtosale']").checked || form.querySelector("input[id*='successsale']").checked || form.querySelector("input[id*='lowrev']").checked){
                                form.querySelector("input[id*='appointment']").setAttribute('disabled', 'disabled');
                                form.querySelector("input[id*='appointment']").value = "";
                            } else {
                                form.querySelector("input[id*='appointment']").removeAttribute('disabled');
                            }
                        }

                        if (isMobileDevice()){
                            loadedData.device = ".mobile-data";
                        }else{
                            loadedData.device = ".desktop-data";
                        }
                        
                        initDateTimePickers();
                        listInfoAgent();
                    </script>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>