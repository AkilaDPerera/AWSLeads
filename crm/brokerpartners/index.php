<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broker Partners</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    
    <?php
        require_once '../backend/constant.php';
        require_once '../components/getAuthenticated.php';
        require_once '../components/loader.php';
    ?>
    <script>
        if (ukey!=="1"){
            window.localStorage.removeItem("r");
            window.localStorage.removeItem("ukey");
            window.localStorage.removeItem("cname");
            window.localStorage.removeItem("jwt");
            alert("Only Jay can access this page.");
            window.location.replace("<?php echo $baseurl ?>?next="+encodeURIComponent(window.location.pathname)); 
        }
    </script>
    <div style="position: fixed; right: 0; top: 0;">
        <div class="d-flex align-items-center">
            <button class="btn btn-link" onclick="logout()">logout</button>
        </div>
    </div>

    <style>
        .hide { display: none; }
        #users .btn[data-pk="1"] { display: none; }
    </style>

    <div class="container mt-5">
        <table class="table table-striped" id="users">
            <thead>
                <tr>
                    <th>PK</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Company</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <script>
            const loadedUsers = {}
            const fetchUsers = async ()=>{
                const formData = new FormData();
                formData.append("ukey", window.localStorage.getItem("ukey"));
                formData.append("jwt", window.localStorage.getItem("jwt"));

                timer.timestart();

                fetch("<?php echo $baseurl ?>brokerpartners/listusers.php", {
                    method: "post",
                    body: formData
                })
                .then((response)=>response.json())
                .then((data)=>{
                    timer.timestop();
                    if (data.success){
                        loadedUsers.users = data.data;
                        document.querySelector("#users tbody").innerHTML="";
                        data.data.forEach((user, i) => {
                            document.querySelector("#users tbody").innerHTML+=`<tr>
                            <td>${user.pk}</td>
                            <td>${user.username}</td>
                            <td>${user.upassword}</td>
                            <td>${user.urole}</td>
                            <td>${user.cname}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-index="${i}" onclick="filleditform(event);">Edit</button>
                                <button class="btn btn-sm btn-danger" data-pk="${user.pk}" onclick="deleteuser(event);">Delete</button>
                            </td>
                            </tr>`;
                        });
                    }
                });
            }
            const filleditform = (e)=>{
                const user = loadedUsers.users[e.target.getAttribute("data-index")];
                document.querySelector("#usermanage #pklabel").innerHTML = user.pk;
                document.querySelector("#usermanage #pk").value = user.pk;
                document.querySelector("#usermanage #username").value = user.username;
                document.querySelector("#usermanage #password").value = user.upassword;
                document.querySelector("#usermanage #role").value = user.urole;
                document.querySelector("#usermanage #company").value = user.cname;
                document.querySelector("#usermanage .btn-add").value = "Update";
                document.querySelector("#usermanage").classList.remove("hide");
            }
            fetchUsers();

            const deleteuser = (e)=>{
                const pk = e.target.getAttribute("data-pk");
                const formData = new FormData();
                formData.append("pk", pk);
                formData.append("jwt", window.localStorage.getItem("jwt"));
                timer.timestart();
                fetch("<?php echo $baseurl ?>brokerpartners/deleteuser.php", {
                    method: "POST",
                    body: formData
                })
                .then((response)=>response.json())
                .then((data)=>{
                    if (data.success){
                        fetchUsers();
                    }else{
                        alert(data.message);
                    }
                    timer.timestop();
                });
            }
        </script>

        <button class="btn btn-primary mt-5 mb-4" onclick="createform();">Create User</button>

        <form action="<?php echo $baseurl ?>brokerpartners/addupdate.php" method="post" onsubmit="addupdateuser(event);">
            <table class="table hide" id="usermanage">
                <thead></thead>
                <tbody>
                    <tr>
                        <td>
                            <label id="pklabel" style="padding: 7px 0;"></label>
                            <input type="text" name="pk" id="pk" hidden class="form-control">
                        </td>
                        <td>
                            <input type="text" name="username" id="username" required placeholder="Username" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="password" id="password" required placeholder="Password" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="role" id="role" required placeholder="Role" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="company" id="company" required placeholder="Company" class="form-control">
                        </td>
                        <td style="display: flex;">
                            <input type="button" class="btn btn-sm btn-primary me-2" value="Cancel" onclick="cancelform();">
                            <input type="submit" class="btn-add btn btn-sm btn-primary" value="Add">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <script>
            const addupdateuser = async (event)=>{
                event.preventDefault();
                const form = event.currentTarget;
                const url = new URL(form.action);
                const formData = new FormData(form);
                formData.append("jwt", window.localStorage.getItem("jwt"));
                timer.timestart();
                fetch(url, {
                    method: form.method,
                    body: formData
                })
                .then((response)=>response.json())
                .then((data)=>{
                    if (data.success){
                        cancelform();
                        fetchUsers();
                    }else{
                        alert(data.message);
                    }
                    timer.timestop();
                });
            }
            const createform = ()=>{
                document.querySelector("#usermanage #pklabel").innerHTML = "";
                document.querySelector("#usermanage #pk").value = "";
                document.querySelector("#usermanage #username").value = "";
                document.querySelector("#usermanage #password").value = "";
                document.querySelector("#usermanage #role").value = "";
                document.querySelector("#usermanage #company").value = "";
                document.querySelector("#usermanage .btn-add").value = "Add";
                document.querySelector("#usermanage").classList.remove("hide");
            }
            const cancelform = ()=>{
                document.querySelector("#usermanage").classList.add("hide");
            }
        </script>
        
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>