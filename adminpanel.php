<?php 
include_once('db.php');


$query  = "SELECT slug,original,renew,activeUrl FROM urls";
$result = $con->query($query);
echo '<!DOCTYPE html><head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head><body><div id="container" class="container">
    <input type="text" id="myInput" onkeyup="search()" placeholder="Search using slug or url">';
    while($index = mysqli_fetch_assoc($result))
    {
        $checked = "";
        if ($index['activeUrl']==1)
        {
            $checked = "checked";
        }
        echo '
        <form id="'.$index['slug'].' || '.$index['original'].'">
            <div class="input-group mb-4" id="slug_'.$index['slug'].'">
                <div class="input-group">
                    <input type="text" readonly class="form-control" id="slug_'.$index['slug'].'" value="'.$index['slug'].'"/>
                    <input type="text" readonly class=" form-control" id="url_'.$index['slug'].'" value="'.$index['original'].'"/>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" '.$checked.' onclick="updateEntry(this)" id="switch _'.$index['slug'].'" class="custom-control-input">
                    <label class="custom-control-label" for="customSwitch1">Activate/Deactivate</label>
                </div>
                <div class="col align-self-end">
                    <button type="button" onclick="deleteEntry(this.id)" id="submit-form btn_'.$index['slug'].'" class="btn btn-danger btn-primary" value="delete">Delete</button>
                </div>
                <label class="custom-control-label"  for="">Renewable?:'.$index['renew'].'   [-1 cant renew,0 renewable,1 renewed]</label>
            </div>
        </form>
        ';
    }
    echo'
    <script>
        
        function search(){
            input = document.getElementById("myInput");
            container = document.getElementById("container");
            form = container.getElementsByTagName("form");
            if (input.value=="")
            {
                for (i = 0; i < form.length; i++) {
                    form[i].style.display = "";
                }
                return false;
            }
            for (i = 0; i < form.length; i++) {
                if (form[i].id.split(" || ")[0].localeCompare(input.value, undefined, { sensitivity: "accent" })==0 || form[i].id.split(" || ")[1].localeCompare(input.value, undefined, { sensitivity: "accent" })==0) {
                  form[i].style.display = "";
                } else {
                  form[i].style.display = "none";
                }
              }
            
        }
        function deleteEntry(id)
        {
            var slug = $.trim(id.substring(16));
            $.post("utilities.php", {
                edit:    "delete",
                switched:   null,
                slug:   slug
                }).always(function(data) {
                    if (data=="pass"){
                        var parent = document.getElementById("slug_"+slug);
                        parent.remove();
                        alert("Deleted");
                    }
                });
        }
        
        function updateEntry(ele)
        {
            var id = ele.id;
            var switched = ele.checked ? 1 : 0;
            var slug = $.trim(id.substring(8));
            $.post("utilities.php", {
                edit:    "switched",
                switched:   switched,
                slug:   slug
                }).always(function(data) {
                    if (data=="pass"){
                        alert("Updated");
                    }
                });
        }
    </script>
    </body>';
    $con->close();
    ?>
            