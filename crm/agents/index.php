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
    </style>
</head>
<body>
    <?php
        require_once '../backend/constant.php';
        require_once '../components/getAuthenticated.php';
        require_once '../components/loader.php';
    ?>

    <script>
        const r = window.localStorage.getItem("r");
        if (r==="o"){
            window.location.replace("<?php echo $baseurl ?>admin/"); 
        }
    </script>

    <div style="position: fixed; right: 0; top: 0;">
        <div class="d-flex align-items-center">
            <div class="company-name me-2" style="text-transform: capitalize;"></div>-<button class="btn btn-link" onclick="logout()">logout</button>
        </div>
    </div>
    <script>
        document.querySelector(".company-name").innerHTML = window.localStorage.getItem("cname");
    </script>

    <div class="mx-4 mt-3">
        <!-- <div>
            <div class="h6">Recommendation for No Answers</div>
            <ul>
                <li class="mt-2">1st No Answer - Leave a message, set future appointment (3 days later), select the No Answer check box, put NA1 in notes, Add Lead</li>
                <li class="mt-2">2nd No Answer - Leave a message, send text, set future appointment (3 days later), put NA2 in notes, Update Lead</li>
                <li class="mt-2">3rd No Answer - Leave simple message - don't want to bother someone that is not interested, call me if you need help, I’m here, check box Remarket, Update Lead We will remarket to them once a month if Remarket is checked.</li>
            </ul>
        </div> -->
    </div>
    
    <div class="accordion mt-5 mx-2" id="mainaccord">

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
                            <input type="text" name="phone" id="phone" class="form-control" maxlength="10" required pattern="[0-9]{10}" onkeyup="phonenumbervalidation(event)"/>
                        </div>
                        <div class="d-inline-block" style="width: 130px;">
                            <label for="phone2" class="form-label">Phone 2</label>
                            <input type="text" name="phone2" id="phone2" class="form-control" maxlength="10" pattern="[0-9]{10}" onkeyup="phonenumbervalidation(event)"/>
                        </div>
                        <div class="d-inline-block" style="width: 300px;">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" maxlength="50"/>
                        </div>
                        <div class="d-inline-block" style="width: 300px;">
                            <label for="web" class="form-label">Website/FB</label>
                            <input type="text" name="web" id="web" class="form-control" maxlength="100"/>
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
                                <input class="form-check-input" type="radio" name="status" id="lowrev" >
                                <label class="form-check-label" for="lowrev">
                                    Remarket
                                </label>
                            </div>
                            <div class="d-block">
                                <div class="d-inline-block me-4 mt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="possibleproperty" name="possibleproperty">
                                    <!-- <input class="form-check-input" type="radio" name="possibletype" id="possibleproperty"> -->
                                    <label class="form-check-label" for="possibleproperty">
                                        +Property Sale
                                    </label>
                                </div>
                                <div class="d-inline-block me-4 mt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="possiblebuyer" name="possiblebuyer">
                                    <!-- <input class="form-check-input" type="radio" name="possibletype" id="possiblebuyer"> -->
                                    <label class="form-check-label" for="possiblebuyer">
                                        +Biz Buyer
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
                    const dateclr = ()=>{
                        document.querySelectorAll("#appointment").forEach((comp)=>{comp.value = "";});
                    }
                    const phonenumbervalidation = (e)=>{
                        e.target.value = e.target.value.replace(/\D/g,'');
                    }
                    const addInfo = (event)=>{
                        event.preventDefault();
                        const form = event.currentTarget;
                        const url = new URL(form.action);
                        const formData = new FormData(form);

                        if (document.querySelector("#addInfoForm #nocontact").checked || document.querySelector("#addInfoForm #followingup").checked){
                            if(!validappointment(document.querySelector("#addInfoForm #appointment").value)){
                                document.querySelector("#addInfoForm #appointment").classList.add("is-invalid");
                                return;
                            };
                        }
                        document.querySelector("#addInfoForm #appointment").classList.remove("is-invalid");

                        formData.append("appointment", getbackendtime(loadedData.adddatetime));
                        formData.append("lowrev", document.querySelector("#addInfoForm #lowrev").checked);
                        formData.append("nocontact", document.querySelector("#addInfoForm #nocontact").checked);
                        formData.append("notinterested", document.querySelector("#addInfoForm #notinterested").checked);
                        formData.append("followingup", document.querySelector("#addInfoForm #followingup").checked);
                        formData.append("listedtosale", document.querySelector("#addInfoForm #listedtosale").checked);
                        formData.append("successsale", document.querySelector("#addInfoForm #successsale").checked);
                        formData.append("possibleproperty", document.querySelector("#addInfoForm #possibleproperty").checked);
                        formData.append("possiblebuyer", document.querySelector("#addInfoForm #possiblebuyer").checked);
                        formData.append("whocreatedpk", window.localStorage.getItem("ukey"));
                        formData.append("whichcompany", window.localStorage.getItem("cname"));
                        formData.append("jwt", window.localStorage.getItem("jwt"));
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
                    <div class="h5">My Leads</div>
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
                                <input type="text" name="phone" id="phone" class="form-control" maxlength="10" required pattern="[0-9]{10}" onkeyup="phonenumbervalidation(event)"/>
                            </div>
                            <div class="d-inline-block" style="width: 130px;">
                                <label for="phone2" class="form-label">Phone 2</label>
                                <input type="text" name="phone2" id="phone2" class="form-control" maxlength="10" pattern="[0-9]{10}" onkeyup="phonenumbervalidation(event)"/>
                            </div>
                            <div class="d-inline-block" style="width: 300px;">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" maxlength="50"/>
                            </div>
                            <div class="d-inline-block" style="width: 300px;">
                                <label for="web" class="form-label">Website/FB</label>
                                <input type="text" name="web" id="web" class="form-control" maxlength="100"/>
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
                                    <input class="form-check-input" type="radio" name="status" id="lowrevu">
                                    <label class="form-check-label" for="lowrevu">
                                        Remarket
                                    </label>
                                </div>
                                <div class="d-block">
                                    <div class="d-inline-block me-4 mt-3">
                                        <input class="form-check-input" type="checkbox" value="" id="possiblepropertyu" name="possibleproperty">
                                        <!-- <input class="form-check-input" type="radio" name="possibletype" id="possiblepropertyu"> -->
                                        <label class="form-check-label" for="possiblepropertyu">
                                            +Property Sale
                                        </label>
                                    </div>
                                    <div class="d-inline-block me-4 mt-3">
                                        <input class="form-check-input" type="checkbox" value="" id="possiblebuyeru" name="possiblebuyer">
                                        <!-- <input class="form-check-input" type="radio" name="possibletype" id="possiblebuyeru"> -->
                                        <label class="form-check-label" for="possiblebuyeru">
                                            +Biz Buyer
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
                        <!-- <div class="table-toggle">
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="0">Company</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="1">Owner</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="2">Revenue</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="3">Agent</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="4">Email</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="5">Phone</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="6">Notes</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="7">No Contact</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="8">Not Interested</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="9">Following Up</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="10">Listed Business for Sale</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="11">Successful Sale</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="12">Possible Buyer</button>
                            <button type="button" class="btn btn-sm active" data-bs-toggle="button" data-column="13">Action</button>
                        </div> -->
                        <table class="table table-striped table-bordered" data-page-length='1000'>
                            <thead>
                                <tr>
                                    <th scope="col">Company</th>
                                    <th scope="col" class="mobile">Owner</th>
                                    <th scope="col">Revenue</th>
                                    <th scope="col">Agent</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Web/FB</th>
                                    <th scope="col" class="mobile">Phone</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col">Appointment</th>
                                    <th scope="col">No Answer</th>
                                    <th scope="col">Not Interested</th>
                                    <th scope="col">Interested</th>
                                    <th scope="col">Listed</th>
                                    <th scope="col">Sold</th>
                                    <th scope="col">Remarket</th>
                                    <th scope="col">+Property Sale</th>
                                    <th scope="col">+Biz Buyer</th>
                                    <th scope="col" class="mobile"></th>
                                    <th scope="col">Remaining</th>
                                </tr>
                            </thead>
                            <tfoot style="display: table-header-group;">
                                <tr>
                                    <th></th>
                                    <th class="mobile"></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="mobile"></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="mobile"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody></tbody>
                        </table>

                        <button class="btn btn-primary desktop" onclick="download();">Download</button>
                    </div>
                    <style>
                        table.dataTable th.dt-type-numeric, table.dataTable th.dt-type-date, table.dataTable td.dt-type-numeric, table.dataTable td.dt-type-date { text-align: left!important;}
                        table td { padding: 0px 2px!important; }
                        table.dataTable > tfoot > tr > th, table.dataTable > tfoot > tr > td { padding: 6px 2px!important; }
                        table.dataTable > thead > tr > th, table.dataTable > thead > tr > td { padding: 2px!important; }
                        table.dataTable tr.green td { background-color: #ccffcc!important;}
                        table.dataTable tr.red td { background-color: #ffcccc!important;}
                        .vertical-text .dt-column-title { writing-mode: tb; text-align: right!important; }
                        .dt-column-order { top: unset!important; bottom: 15px!important; }
                        .vertical-text .dt-column-order { right: 25px!important; }
                        .dt-layout-row .dt-layout-start { display: none!important; }
                        .dt-layout-row .dt-layout-end { display: block!important; margin-left: unset!important; }
                        tfoot th input { max-width: 50px; }
                        @media (max-width: 750px) {
                            .desktop { display: none!important; }
                            .mobile { display: table-cell!important; }
                        }
                    </style>

                    <script>
                        const loadedData = {};
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
                            document.querySelector("#updateInfoForm #revenue").value = record.revenue;
                            // document.querySelector("#updateInfoForm #aname").value = record.aname;
                            record.appointment===""?document.querySelector("#updateInfoForm #appointment").value = "":document.querySelector("#updateInfoForm #appointment").value = getfrontendtime(record.appointment.replaceAll(" ", "T"));
                            document.querySelector("#updateInfoForm #lowrevu").checked = record.lowrev==="f"?false:true;
                            document.querySelector("#updateInfoForm #nocontactu").checked = record.nocontact==="f"?false:true;
                            document.querySelector("#updateInfoForm #notinterestedu").checked = record.notinterested==="f"?false:true;
                            document.querySelector("#updateInfoForm #followingupu").checked = record.followingup==="f"?false:true;
                            document.querySelector("#updateInfoForm #listedtosaleu").checked = record.listedtosale==="f"?false:true;
                            document.querySelector("#updateInfoForm #successsaleu").checked = record.successsale==="f"?false:true;
                            document.querySelector("#updateInfoForm #possiblepropertyu").checked = record.possibleproperty==="f"?false:true;
                            document.querySelector("#updateInfoForm #possiblebuyeru").checked = record.possiblebuyer==="f"?false:true;
                            document.querySelector("#updateInfoForm #notes").value = record.notes;
                            document.querySelector("#updateInfoForm").classList.remove("hide");
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                        const populateSearchResult = (data)=>{
                            const tableEle = document.querySelector("#searchInfoSection table tbody");
                            try{ loadedData.table.destroy(); }catch{}
                            tableEle.innerHTML = "";
                            today = new Date();
                            data.forEach((record, i) => {
                                remaining = "9999999.999";
                                istoday = false;
                                if (record.appointment!=""){
                                    appo = new Date(Date.parse(record.appointment));
                                    istoday = appo.getDate() == today.getDate();
                                    remaining = (appo-today)/(1000);
                                }
                                
                                if (record.lowrev==="t"){ remaining = "999999996"; }
                                if (record.notinterested==="t"){ remaining = "999999997"; }
                                if (record.listedtosale=="t"){ remaining = "999999998"; }
                                if (record.successsale=="t"){ remaining = "999999999"; }

                                tense = "";
                                if (remaining<0){ tense = "class='red'"; } else if (istoday && remaining<(24*60*60)){ tense="class='green'"; } else { tense=""; }

                                tableEle.innerHTML += `<tr ${tense}>
                                <td>${record.company}</td><td>${record.uname}</td><td>${record.revenue}</td><td>${record.username}</td>
                                <td><a href= "mailto: ${record.email}">${record.email}</a></td><td>${record.web}</td><td><a href="tel:+1${record.phone}">${record.phone}</a>, <a href="tel:+1${record.phone2}">${record.phone2}</a></td>
                                <td>${record.notes}</td>
                                <td>${getfrontendtime(record.appointment)}</td>
                                <td>${record.nocontact==="t"?'<span class="badge text-bg-success">T</span>':'<span class="badge text-bg-danger">F</span>'}</td>
                                <td>${record.notinterested==="t"?'<span class="badge text-bg-success">T</span>':'<span class="badge text-bg-danger">F</span>'}</td>
                                <td>${record.followingup=="t"?'<span class="badge text-bg-success">T</span>':'<span class="badge text-bg-danger">F</span>'}</td>
                                <td>${record.listedtosale=="t"?'<span class="badge text-bg-success">T</span>':'<span class="badge text-bg-danger">F</span>'}</td>
                                <td>${record.successsale=="t"?'<span class="badge text-bg-success">T</span>':'<span class="badge text-bg-danger">F</span>'}</td>
                                <td>${record.lowrev=="t"?'<span class="badge text-bg-success">T</span>':'<span class="badge text-bg-danger">F</span>'}</td>
                                <td>${record.possibleproperty=="t"?'<span class="badge text-bg-success">T</span>':'<span class="badge text-bg-danger">F</span>'}</td>
                                <td>${record.possiblebuyer=="t"?'<span class="badge text-bg-success">T</span>':'<span class="badge text-bg-danger">F</span>'}</td>
                                <td><button class="btn btn-primary btn-sm" data-index="${i}" data-key="${record.pk}" onclick="editButtonHandler(event);">EDIT</button></td>
                                <td>${remaining}</td>
                                </tr>`;
                            });
                            document.querySelectorAll('.table-toggle button').forEach((el) => {
                                if (!el.classList.contains("active")){ el.classList.add("active"); }
                            });
                            if(!loadedData.table){
                                document.querySelectorAll('.table-toggle button').forEach((el) => {
                                    el.addEventListener('click', function (e) {
                                        let columnIdx = e.target.getAttribute('data-column');
                                        let column = loadedData.table.column(columnIdx);
                                        column.visible(!column.visible());
                                    });
                                });
                            }

                            loadedData.table = new DataTable('#searchInfoSection table', {
                                responsive: true,
                                searching: true,
                                order: [[18, 'asc']],
                                columnDefs: [
                                    { target: [5, 9], visible: false },
                                    { targets:[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18], className: "desktop" },
                                    { targets:[1, 6, 17], className: "mobile" },
                                    { target:17, visible: true, searchable: false}, { target:18, visible: false, searchable: false}
                                ],
                                initComplete: function () {
                                    this.api()
                                    .columns()
                                    .every(function () {
                                        let column = this;
                                        let title = column.footer().textContent;
                        
                                        // Create input element
                                        let input = document.createElement('input');
                                        input.placeholder = title;
                                        column.footer().replaceChildren(input);
                        
                                        // Event listener for user input
                                        input.addEventListener('keyup', () => {
                                            if (column.search() !== this.value) {
                                                loadedData.searchtable = column.search(input.value).draw();
                                                loadedData.searchedArray = loadedData.searchtable.rows( {search: 'applied'} ).data().toArray();
                                            }
                                        });
                                    });
                                },
                            });
                            loadedData.searchedArray = loadedData.table.rows( {search: 'applied'} ).data().toArray();
                        }
                        const searchInfo = (event)=>{
                            event.preventDefault();
                            const form = event.currentTarget;
                            const url = new URL(form.action);
                            const formData = new FormData(form);
                            formData.append("whichcompany", window.localStorage.getItem("cname"));
                            formData.append("jwt", window.localStorage.getItem("jwt"));

                            timer.timestart();

                            if (formData.get("phone")==="" && formData.get("email")===""){
                                timer.timestop();
                                alert("Please enter a valid phone number or email address to search.");
                                return;
                            }
                            
                            fetch(url, {
                                method: form.method,
                                body: formData
                            })
                            .then((response)=>response.json())
                            .then((data)=>{
                                timer.timestop();
                                if (data.success){
                                    // clear fields
                                    document.querySelector("#searchInfoForm #email").value = "";
                                    document.querySelector("#searchInfoForm #phone").value = "";
                                    loadedData.data = data.data;
                                    populateSearchResult(data.data);
                                }else{
                                    alert(data.message);
                                }
                            });
                        }
                        const updateInfo = (event)=>{
                            event.preventDefault();
                            const form = event.currentTarget;
                            const url = new URL(form.action);
                            const formData = new FormData(form);

                            if (document.querySelector("#updateInfoForm #nocontactu").checked || document.querySelector("#updateInfoForm #followingupu").checked){
                                if(!validappointment(document.querySelector("#updateInfoForm #appointment").value)){
                                    document.querySelector("#updateInfoForm #appointment").classList.add("is-invalid");
                                    return;
                                };
                            }
                            document.querySelector("#updateInfoForm #appointment").classList.remove("is-invalid");
                            
                            formData.append("appointment", getbackendtime(loadedData.updatedatetime));
                            formData.append("lowrev", document.querySelector("#updateInfoForm #lowrevu").checked);
                            formData.append("nocontact", document.querySelector("#updateInfoForm #nocontactu").checked);
                            formData.append("notinterested", document.querySelector("#updateInfoForm #notinterestedu").checked);
                            formData.append("followingup", document.querySelector("#updateInfoForm #followingupu").checked);
                            formData.append("listedtosale", document.querySelector("#updateInfoForm #listedtosaleu").checked);
                            formData.append("successsale", document.querySelector("#updateInfoForm #successsaleu").checked);
                            formData.append("possibleproperty", document.querySelector("#updateInfoForm #possiblepropertyu").checked);
                            formData.append("possiblebuyer", document.querySelector("#updateInfoForm #possiblebuyeru").checked);
                            formData.append("whichcompany", window.localStorage.getItem("cname"));
                            formData.append("jwt", window.localStorage.getItem("jwt"));
                            timer.timestart();
                            fetch(url, {
                                method: form.method,
                                body: formData
                            })
                            .then((response)=>response.json())
                            .then((data)=>{
                                if (data.success){
                                    document.querySelector("#updateInfoForm").classList.add("hide");
                                    const record = {...loadedData.data[loadedData.selectedToEdit]};
                                    record.email = document.querySelector("#updateInfoForm #email").value;
                                    record.phone = document.querySelector("#updateInfoForm #phone").value;
                                    record.phone2 = document.querySelector("#updateInfoForm #phone2").value;
                                    record.company = document.querySelector("#updateInfoForm #company").value;
                                    record.uname = document.querySelector("#updateInfoForm #uname").value;
                                    record.web = document.querySelector("#updateInfoForm #web").value;
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
                                    record.notes = document.querySelector("#updateInfoForm #notes").value;
                                    loadedData.data[loadedData.selectedToEdit] = record;
                                    populateSearchResult(loadedData.data);
                                }else{
                                    alert(data.message);
                                }
                                timer.timestop();
                            });
                        }
                        const listInfoAgent = ()=>{
                            const formData = new FormData();
                            formData.append("whichcompany", window.localStorage.getItem("cname"));
                            formData.append("ukey", window.localStorage.getItem("ukey"));
                            formData.append("jwt", window.localStorage.getItem("jwt"));

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
                        const download = ()=>{
                            let csvContent = "data:text/csv;charset=utf-8,";

                            // clean the search array
                            const cleanData = [[
                                "Company", "Owner", "Revenue", "Agent", "Email", "Web/FB", "Phone", "Notes", "Appointment", "No Answer", "Not Interested", "Interested",
                                "Listed", "Sold", "Remarket", "PProperty", "PBuyer"
                            ]];
                            loadedData.searchedArray.forEach(function(rowArray) {
                                rowArray[9] = rowArray[9].includes("T")?"TRUE":"FALSE";
                                rowArray[10] = rowArray[10].includes("T")?"TRUE":"FALSE";
                                rowArray[11] = rowArray[11].includes("T")?"TRUE":"FALSE";
                                rowArray[12] = rowArray[12].includes("T")?"TRUE":"FALSE";
                                rowArray[13] = rowArray[13].includes("T")?"TRUE":"FALSE";
                                rowArray[14] = rowArray[14].includes("T")?"TRUE":"FALSE";
                                rowArray[15] = rowArray[15].includes("T")?"TRUE":"FALSE";
                                rowArray[16] = rowArray[16].includes("T")?"TRUE":"FALSE";
                                delete rowArray[17];
                                delete rowArray[18];
                                cleanData.push(rowArray);
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
                        const getbackendtime = (picker)=>{
                            // Y-m-dTH:i
                            if (picker.val()==""){ return ""; }
                            a = new Date(picker.val());
                            return `${a.getFullYear()}-${addleadingzeros(a.getMonth()+1)}-${addleadingzeros(a.getDate())}T${addleadingzeros(a.getHours())}:${addleadingzeros(a.getMinutes())}`
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
                                if (appointmentComp.value==""){ appointmentComp.classList.add("is-invalid"); return; }
                                if(!validappointment(appointmentComp.value)){
                                    appointmentComp.classList.add("is-invalid");
                                } else {
                                    appointmentComp.classList.remove("is-invalid");
                                }
                            } else {
                                form.querySelector("input[id*='appointment']").classList.remove("is-invalid");
                            }
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