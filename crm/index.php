<?php
    require_once 'backend/constant.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
        require_once 'components/loader.php';
    ?>
    <div class="container d-flex">
        <div class="mt-5 col-11 col-sm-6 col-lg-3">
            <h1 class="mb-4">Login</h1>
            <form onsubmit="loginSubmit(event);" method="POST" id="loginform" action="<?php echo $baseurl ?>login/login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <script>
                const loginSubmit = (event)=>{
                    event.preventDefault();
                    const form = event.currentTarget;
                    const url = new URL(form.action);
                    const formData = new FormData(form);
                    timer.timestart();
                    fetch(url, {
                        method: form.method,
                        body: formData
                    })
                    .then((response)=>response.json())
                    .then((data)=>{
                        timer.timestop();
                        if (data.success){
                            window.sessionStorage.setItem("r", data.role[0]);
                            window.sessionStorage.setItem("ukey", data.ukey);
                            window.sessionStorage.setItem("cname", data.cname);
                            window.sessionStorage.setItem("jwt", data.jwt);
                            const currentURL = new URLSearchParams(document.location.search);
                            if(currentURL.get("next")!==null){
                                window.location.replace(currentURL.get("next"));
                            } else {
                                window.location.replace("<?php echo $baseurl ?>agents/");
                            }
                        }else{
                            window.sessionStorage.removeItem("r");
                            window.sessionStorage.removeItem("ukey");
                            window.sessionStorage.removeItem("cname");
                            window.sessionStorage.removeItem("jwt");
                            alert(data.message);
                        }
                    });
                }
            </script>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>