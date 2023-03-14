<?php

?>

<html>
  <head>
    <title>Submit Form</title>
    <script
      src="https://code.jquery.com/jquery-3.4.1.min.js"
      integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
      crossorigin="anonymous"></script>
  
    <script src="https://www.google.com/recaptcha/api.js?render=6LfIhssiAAAAAOvAWGXlrATx5wvPKOeH0IEdJsXv"></script>
  </head>
  
  <body>
    <div>
      <b>Submit Form</b>
    </div>
  
    <form id="submitForm" action="rechapta_2.php" method="post">
      <div>
          <div>
              <input type="text" id="inputText" name="inputText">
          </div>
          <div>
              <input type="submit" value="submit">
          </div>
      </div>
    </form>
  
    <script>
    $('#submitForm').submit(function(event) {
        event.preventDefault();
        var inputText = $('#inputText').val();
  
        grecaptcha.ready(function() {
            grecaptcha.execute('6LfIhssiAAAAAOvAWGXlrATx5wvPKOeH0IEdJsXv', {action: 'submit'}).then(function(token) {
                $('#submitForm').prepend('<input type="hidden" name="token" value="' + token + '">');
                $('#submitForm').prepend('<input type="hidden" name="action" value="submit">');
                $('#submitForm').unbind('submit').submit();
            });;
        });
  });
  </script>
  </body>
</html>