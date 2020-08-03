$(document).ready(function() {
  
    $("#network_status").on('change', function (e) {
  
      var status = e.target.checked;
  
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/member/network-check',
        type: 'POST',
        data: {status: status},
        success: function(data) {
          if (status) {
            document.getElementById("background").disabled = false;
            document.getElementById("sel_skill").disabled = false;
            document.getElementById("sel_need").disabled = false;

          } else {
            document.getElementById("background").disabled = true;
            document.getElementById("sel_skill").disabled = true;
            document.getElementById("sel_need").disabled = true;
          }
        },
        error: function (error) {
          console.log(error);
        }
      });
    })
    
  });