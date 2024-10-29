<!-- Proper authentication for agents page -->

<!-- 
Dependency files 
1. /backend/constant.php
-->

<script>
    const ukey = window.localStorage.getItem("ukey");
    const role = window.localStorage.getItem("r");
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
        window.localStorage.removeItem("r");
        window.localStorage.removeItem("ukey");
        window.localStorage.removeItem("cname");
        window.localStorage.removeItem("jwt");
        window.location.replace("<?php echo $baseurl ?>"); 
    }
</script>
