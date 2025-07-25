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
        if (r==="a"){
            window.location.replace("<?php echo $baseurl ?>agents/"); 
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
        const cname = window.sessionStorage.getItem("cname");
    </script>

    <div class="mx-4 mt-3">
        <div class="mt-0">
            <!-- <div class="h6 mb-1">Recommendation for No Answers</div> -->
            <ul class="mb-1">
                <li>If you want to set a specific time and date to contact a lead, uncheck NA.</li>
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
                <form action="<?php echo $baseurl ?>agents/addInfo.php" method="post" onsubmit="addInfo(event);" class="accordion-body my-2" onchange="selfvalidate(event);">
                    <div class="row g-3 mb-3">
                        <div class="d-inline-block" style="width: 130px;">
                            <label for="phone" class="form-label">Phone 1*</label>
                            <input type="text" name="phone" id="phone" class="form-control" required maxlength="20" pattern="[0-9]{10}" onkeyup="phonenumbervalidation(event)"/>
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
                        <div class="d-inline-block" style="width: 140px;">
                            <label for="owner" class="form-label">Agent Name</label>
                            <select name="whocreatedpk" id="owner" class="form-control" style="text-transform: capitalize;">
                            </select>
                        </div>
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
                                <input class="form-check-input" type="radio" name="status" id="nocontact">
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
                                <div class="d-inline-block me-4 mt-3">
                                    <input class="form-check-input" type="radio" name="status" id="nofinance" >
                                    <label class="form-check-label" for="nofinance">
                                        Waiting For Financials
                                    </label>
                                </div>
                                <div class="d-inline-block me-4 mt-3">
                                    <input class="form-check-input" type="radio" name="status" id="gotfinance" >
                                    <label class="form-check-label" for="gotfinance">
                                        Received Financials
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

                        while (daysAdded <= 0) {
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
                        formData.append("nofinance", document.querySelector("#addInfoForm #nofinance").checked);
                        formData.append("gotfinance", document.querySelector("#addInfoForm #gotfinance").checked);
                        formData.append("nocontact", document.querySelector("#addInfoForm #nocontact").checked);
                        formData.append("notinterested", document.querySelector("#addInfoForm #notinterested").checked);
                        formData.append("followingup", document.querySelector("#addInfoForm #followingup").checked);
                        formData.append("listedtosale", document.querySelector("#addInfoForm #listedtosale").checked);
                        formData.append("successsale", document.querySelector("#addInfoForm #successsale").checked);
                        formData.append("possibleproperty", document.querySelector("#addInfoForm #possibleproperty").checked);
                        formData.append("possiblebuyer", document.querySelector("#addInfoForm #possiblebuyer").checked);
                        formData.append("na1", document.querySelector("#addInfoForm #na1").checked);
                        formData.append("na2", document.querySelector("#addInfoForm #na2").checked);
                        formData.append("whichcompany", loadedData.users.find(user => user.pk === document.querySelector("#addInfoForm #owner").value).cname);
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
                                document.querySelector("#addInfoForm #nofinance").checked = false;
                                document.querySelector("#addInfoForm #gotfinance").checked = false;
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
                                listAllInfo();
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
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    <div class="h5">Edit Leads</div>
                </button>
            </div>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#mainaccord">
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
                            <div class="d-inline-block" style="width: 140px;">
                                <label for="owner" class="form-label">Agent Name</label>
                                <select name="whocreatedpk" id="owner" class="form-control" style="text-transform: capitalize;">
                                    <option value="akila">akila - agent</option>
                                    <option value="akila2">akila2 - agent</option>
                                </select>
                            </div>
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
                                    <div class="d-inline-block me-4 mt-3">
                                        <input class="form-check-input" type="radio" name="status" id="nofinanceu" >
                                        <label class="form-check-label" for="nofinanceu">
                                            Waiting For Financials
                                        </label>
                                    </div>
                                    <div class="d-inline-block me-4 mt-3">
                                        <input class="form-check-input" type="radio" name="status" id="gotfinanceu" >
                                        <label class="form-check-label" for="gotfinanceu">
                                            Received Financials
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

                        <input style="margin-bottom: 10px;" type="text" placeholder="Search" name="globalsearch" id="globalsearch" autocomplete="off" onkeydown="searchInfo(event)">

                        <table class="table searchresults">
                            <thead>
                                <th>PK</th>
                                <th>Phones</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
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
                        .desktop-data { display: none; }
                        @media (min-width: 1260px) {
                            .desktop-data { display: none; }
                            .mobile-data { display: none; }
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
                            loadedData.selectedToEdit = event.target.getAttribute("data-key");
                            const record = loadedData.data.find(item => item.pk === loadedData.selectedToEdit);
                            document.querySelector("#updateInfoForm #pk").value = record.pk;
                            document.querySelector("#updateInfoForm #oldemail").value = record.email;
                            document.querySelector("#updateInfoForm #oldphone").value = record.phone;
                            document.querySelector("#updateInfoForm #oldphone2").value = record.phone2;
                            document.querySelector("#updateInfoForm #email").value = record.email;
                            document.querySelector("#updateInfoForm #phone").value = record.phone;
                            document.querySelector("#updateInfoForm #phone2").value = record.phone2;
                            document.querySelector("#updateInfoForm #address").value = record.address;
                            document.querySelector("#updateInfoForm #company").value = record.company;
                            document.querySelector("#updateInfoForm #uname").value = record.uname;
                            document.querySelector("#updateInfoForm #web").value = record.web;
                            document.querySelector("#updateInfoForm #revenue").value = record.revenue;
                            // document.querySelector("#updateInfoForm #aname").value = record.aname;
                            
                            if(checkpastdate(record.appointment.replaceAll(" ", "T"))){
                                document.querySelector("#updateInfoForm #appointment").value = ""
                            }else{
                                document.querySelector("#updateInfoForm #appointment").value = getfrontendtime(record.appointment.replaceAll(" ", "T"));
                            }

                            document.querySelector("#updateInfoForm #lowrevu").checked = record.lowrev==="f"?false:true;
                            document.querySelector("#updateInfoForm #nofinanceu").checked = record.nofinance==="f"?false:true;
                            document.querySelector("#updateInfoForm #gotfinanceu").checked = record.gotfinance==="f"?false:true;
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
                            if(record.whichcompany!=cname){
                                // document.querySelector("#updateInfoForm #owner").setAttribute('disabled', 'disabled');
                                // document.querySelector("#updateInfoForm #owner").value = '';
                                document.querySelector("#updateInfoForm #owner").removeAttribute('disabled');
                                document.querySelector("#updateInfoForm #owner").value = record.whocreatedpk;
                            } else {
                                document.querySelector("#updateInfoForm #owner").removeAttribute('disabled');
                                document.querySelector("#updateInfoForm #owner").value = record.whocreatedpk;
                            }
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
                            var dataString = "";
                            for (let index = 0; index < data.length; index++) {
                                const element = data[index];
                                dataString += `<tr>
                                <td>${element.pk}</td>
                                <td>${element.phone} | ${element.phone}</td>
                                <td><button class="btn btn-primary btn-sm" data-key="${element.pk}" onclick="editButtonHandler(event);">EDIT</button></td>
                                </tr>`
                            }
                            document.querySelector(".searchresults tbody").innerHTML = dataString;
                        }
                        
                        const searchInfo = (e)=>{
                            try {window.clearTimeout(loadedData.debouncesearch)}catch{}
                            loadedData.debouncesearch = window.setTimeout(()=>{
                                // loadedData.data
                                var keyword = document.querySelector("#globalsearch").value;
                                keyword = keyword.replace(/[-\s]/g, '');
                                if (keyword.startsWith('1')) {
                                    keyword = keyword.substring(1);
                                }
                                if (keyword.trim()==""){ return; }
                                const resultData = loadedData.data.filter(item => {
                                    const phoneMatch = item.phone && item.phone.includes(keyword);
                                    const phone2Match = item.phone2 && item.phone2.includes(keyword);
                                    return phoneMatch || phone2Match;
                                });
                                populateSearchResult(resultData);
                            }, 1000);
                        }
                        const updateInfo = (event)=>{
                            event.preventDefault();
                            const form = event.currentTarget;
                            const url = new URL(form.action);
                            const formData = new FormData(form);

                            const originalObj = loadedData.data.find(item => item.pk === loadedData.selectedToEdit);
                            
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
                                const newdate = getDateAfterThreeDaysExcludingWeekends(new Date(), originalObj.appointment);
                                document.querySelector("#updateInfoForm #appointment").value = getfrontendtime(getDateToBackendTime(newdate).replaceAll("T", " "));
                                formData.set("appointment", getDateToBackendTime(newdate));
                            } else {
                                formData.set("appointment", getbackendtime(loadedData.updatedatetime));
                            }
                            
                            formData.append("lowrev", document.querySelector("#updateInfoForm #lowrevu").checked);
                            formData.append("nofinance", document.querySelector("#updateInfoForm #nofinanceu").checked);
                            formData.append("gotfinance", document.querySelector("#updateInfoForm #gotfinanceu").checked);
                            formData.append("nocontact", document.querySelector("#updateInfoForm #nocontactu").checked);
                            formData.append("notinterested", document.querySelector("#updateInfoForm #notinterestedu").checked);
                            formData.append("followingup", document.querySelector("#updateInfoForm #followingupu").checked);
                            formData.append("listedtosale", document.querySelector("#updateInfoForm #listedtosaleu").checked);
                            formData.append("successsale", document.querySelector("#updateInfoForm #successsaleu").checked);
                            formData.append("possibleproperty", document.querySelector("#updateInfoForm #possiblepropertyu").checked);
                            formData.append("possiblebuyer", document.querySelector("#updateInfoForm #possiblebuyeru").checked);
                            formData.append("na1", document.querySelector("#updateInfoForm #na1u").checked);
                            formData.append("na2", document.querySelector("#updateInfoForm #na2u").checked);
                            formData.append("whichcompany", loadedData.users.find(user => user.pk === document.querySelector("#updateInfoForm #owner").value).cname);
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
                                    // clear search params
                                    document.querySelector("#globalsearch").value = "";
                                    document.querySelector(".searchresults tbody").innerHTML = "";
                                    listAllInfo();
                                }else{
                                    alert(data.message);
                                }
                            });
                        }
                        const listAllInfo = ()=>{
                            const formData = new FormData();
                            formData.append("whichcompany", window.sessionStorage.getItem("cname"));
                            formData.append("jwt", window.sessionStorage.getItem("jwt"));
                            formData.append("ukey", window.sessionStorage.getItem("ukey"));
                            formData.append("role", window.sessionStorage.getItem("r"));

                            timer.timestart();

                            fetch("<?php echo $baseurl ?>agents/listAllInfo.php", {
                                method: "post",
                                body: formData
                            })
                            .then((response)=>response.json())
                            .then((data)=>{
                                timer.timestop();
                                if (data.success){
                                    loadedData.data = data.data;
                                }
                            });
                        }
                        const getpkfromstringhtml = (htmlString) => {
                            const match = htmlString.match(/data-key="(\d+)"/);
                            return match ? match[1] : null;
                        }
                        const download = ()=>{
                            let csvContent = "data:text/csv;charset=utf-8,";

                            // clean the search array
                            const cleanData = [[
                                "Company", "Owner", "Revenue", "Agent", "Email", "Web/FB", "Phone", "Notes", "Appointment", "Not Interested", "Interested",
                                "Listed", "Sold", "Remarket", "Waiting For Financials", "PProperty", "PBuyer"
                            ]];
                            loadedData.filteredData.forEach(function(object) {
                                cleanData.push([
                                    object.company, object.uname, object.revenue, object.username, object.email, object.web, object.phone + " - " + object.phone2,
                                    object.notes.replaceAll("\r\n", "\t").replaceAll("#", "No:"), object.appointment, 
                                    object.notinterested=="t"?"True":"False", object.followingup=="t"?"True":"False", object.listedtosale=="t"?"True":"False", 
                                    object.successsale=="t"?"True":"False", object.lowrev=="t"?"True":"False", object.nofinance=="t"?"True":"False", 
                                    object.gotfinance=="t"?"True":"False", object.possibleproperty=="t"?"True":"False", 
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
                        const getLocalDateTime = (datestring) => {
                            const timeZoneOffset = -(new Date().getTimezoneOffset())/60;
                            const date = new Date(datestring);

                            // Calculate UTC time in milliseconds
                            const utcMilliseconds = date.getTime() + date.getTimezoneOffset() * 60000;

                            // Apply the desired timezone offset
                            const localDate = new Date(utcMilliseconds + timeZoneOffset * 3600000);

                            // Format the date and time
                            const year = localDate.getFullYear();
                            const month = String(localDate.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                            const day = String(localDate.getDate()).padStart(2, '0');

                            let hours = date.getHours();
                            // Determine AM/PM
                            const amPm = hours >= 12 ? 'pm' : 'am';
                            // Convert to 12-hour format
                            hours = hours % 12 || 12; // Convert "0" to "12" for midnight
                            const minutes = String(localDate.getMinutes()).padStart(2, '0');

                            return `${year}-${month}-${day} ${hours}:${minutes} ${amPm}`;
                        }
                        const getfrontendtime = (datestring)=>{
                            // Y-m-d H:i -> Y-m-d h:mm a
                            if (datestring==""){ return ""; }
                            return getLocalDateTime(datestring);
                            // a = new Date(datestring);
                            // [d, t, s] = a.toLocaleString().split(" ");
                            // return a.toISOString().slice(0, 10) + " " + t.slice(0, -3) + " " + s.toLowerCase();
                        }
                        const parseCustomDate = (dateString) => {
                            const [datePart, timePart, amPm] = dateString.split(/[\s]+/);
                            const [year, month, day] = datePart.split('-').map(Number);
                            let [hours, minutes] = timePart.split(':').map(Number);

                            // Convert to 24-hour format
                            if (amPm.toLowerCase() === 'pm' && hours < 12) {
                                hours += 12;
                            } else if (amPm.toLowerCase() === 'am' && hours === 12) {
                                hours = 0;
                            }

                            return new Date(year, month - 1, day, hours, minutes);
                        }
                        const validappointment = (datetimefrontendstring)=>{
                            if (datetimefrontendstring=="") { return false; }
                            a = parseCustomDate(datetimefrontendstring);
                            today = new Date();
                            yesterday = new Date(today);
                            yesterday.setDate(today.getDate() - 2);
                            return a>yesterday;
                        }
                        const getusers = ()=>{
                            const formData = new FormData();
                            formData.append("whichcompany", window.sessionStorage.getItem("cname"));
                            formData.append("jwt", window.sessionStorage.getItem("jwt"));
                            formData.append("ukey", window.sessionStorage.getItem("ukey"));
                            formData.append("role", window.sessionStorage.getItem("r"));

                            fetch("<?php echo $baseurl ?>agents/getUsers.php", {
                                method: "post",
                                body: formData
                            })
                            .then((response)=>response.json())
                            .then((data)=>{
                                if (data.success){
                                    loadedData.users = data.data;
                                    optionscontent = "";
                                    loadedData.users.forEach((user)=>{
                                        optionscontent += `<option value='${user.pk}'>(${user.urole[0].toUpperCase()}) ${user.username} - ${user.cname}</option>`;
                                    });
                                    document.querySelectorAll("#owner").forEach((comp)=>{
                                        comp.innerHTML = optionscontent;
                                    });
                                }
                            });
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
                        
                        initDateTimePickers();
                        listAllInfo();
                        getusers();
                    </script>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>