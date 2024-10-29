<!-- Dependency 
    constant.php
-->
<script>
    const ukey = window.localStorage.getItem("ukey");
    const role = window.localStorage.getItem("r");
    if (ukey===null || role===null){
        // Get authenticated again
        window.location.replace("<?php echo $baseurl ?>login"); 
    } else {
        // Nothing to perform
        if (role!=="s"){
            window.localStorage.removeItem("r");
            window.localStorage.removeItem("ukey");
            window.localStorage.removeItem("cname");
            window.localStorage.removeItem("jwt");
            window.location.replace("<?php echo $baseurl ?>login"); 
        }
    }    
    const logout = ()=>{
        window.localStorage.removeItem("r");
        window.localStorage.removeItem("ukey");
        window.localStorage.removeItem("cname");
        window.localStorage.removeItem("jwt");
        window.location.replace("<?php echo $baseurl ?>login"); 
    }
</script>
