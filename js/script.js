function auto() {
  $(function() {
        $.getJSON("autocomplete.php", function(data){
          //console.log("Data -> " ,data);
          var return_items = [];
          $(data).each(function(key, value){
            return_items.push(value.name);
            console.log(value.name);
          });
          $("#q").autocomplete({
            source:return_items
          });
    });
  });
}
function DeleteUser(id) {
    var conf = confirm("Are you sure you want to delete this user?");
    if (conf == true) {
        $.post("delete_user.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}
function DeleteProduct(id) {
    var conf = confirm("Are you sure you want to delete this product?");
    if (conf == true) {
        $.post("delete.php", {
                id: id
            },
            function (data, status) {
              if(1==1){
    window.location.href = 'dashboard.php';
}
            }
        );
    }
}
