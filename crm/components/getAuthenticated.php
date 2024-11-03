<!-- Proper authentication for agents page -->

<!-- 
Dependency files 
1. /backend/constant.php
-->

<script>
    const ukey = window.sessionStorage.getItem("ukey");
    const role = window.sessionStorage.getItem("r");
    if (ukey===null || role===null){
        // Get authenticated again
        window.location.replace("<?php echo $baseurl ?>?next="+encodeURIComponent(window.location.pathname)); 
    } else {
        // Nothing to perform
        if (role==="s"){
            window.location.replace("<?php echo $baseurl ?>?next="+encodeURIComponent(window.location.pathname)); 
        }
    }    
    const logout = ()=>{
        window.sessionStorage.removeItem("r");
        window.sessionStorage.removeItem("ukey");
        window.sessionStorage.removeItem("cname");
        window.sessionStorage.removeItem("jwt");
        window.location.replace("<?php echo $baseurl ?>"); 
    }
</script>
