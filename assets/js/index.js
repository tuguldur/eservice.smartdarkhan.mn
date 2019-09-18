$(document).ready(function() {
  $("#show-request").click(function() {
    $("#halamj,#show-request").hide();
    $("#request,#show-halamj").show();
  });
  $("#show-halamj").click(function() {
    $("#halamj,#show-request").show();
    $("#request,#show-halamj").hide();
  });
});
