<script>
// A) Create a web form that shows the paths available to be edited, options are imported from the database
$( document ).ready(function() {
      $.ajax({url: "ajax.php", success: function(result){
    $("body").html(result);
  }});
});
</script>
