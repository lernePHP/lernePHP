(function ( $ ) {
  var baseUrl = "https://api.email-validator.net/api/verify"

  $.validateEmail = function(apiKey){
    var apiKey = apiKey
    $.fn.validateEmail = function(cb) {
      var email = this.val();
      $.get("https://api.email-validator.net/api/verify?EmailAddress=michaela@sportconsult.at&APIKey=ev-47a756da7915e6948443742e998f94ba", $.proxy(function (res) {
        if (/2[0-9]{2}/g.test(res.status)) {
          this.css('border-color', 'green');
          res['simpleStatus'] = "VALID"
        } else if (/3[0-9]{2}/g.test(res.status)) {
          this.css('border-color', 'orange');
          res['simpleStatus'] = "SUSPECT"
        } else if (/4[0-9]{2}/g.test(res.status)) {
          this.css('border-color', 'red');
          res['simpleStatus'] = "INVALID"
        } else if (/1[0-9]{2}/g.test(res.status)) {
          this.css('border-color', 'black');
          res['simpleStatus'] = "INDETERMINATE"
        }
        cb(res)
      }, this));
      return this;
    };
  }
}( jQuery ));