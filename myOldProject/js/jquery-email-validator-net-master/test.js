$( document ).ready(function() {
	console.log("in test.js");
  // Init only once
  $.validateEmail("ev-47a756da7915e6948443742e998f94ba");

  // OnClick
  $("#submit").click(function () {
    $("#email").validateEmail(function (response) {
      console.log(response);
    })
  })
});
