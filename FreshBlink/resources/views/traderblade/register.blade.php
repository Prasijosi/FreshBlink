<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register Trader - FreshBlink</title>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/registertrader.css') }}">
  </head>
<body>

@include('traderblade.tradernav') 

  <!-- ========== MAIN CONTENT ========== -->
  <div class="form-container">
    <h2>Trader Registration Form</h2>
    <form id="trader-form">
      <label for="fullname">Full Name:</label>
      <input type="text" id="fullname" name="fullname" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <label for="confirm-password">Confirm Password:</label>
      <input type="password" id="confirm-password" name="confirm-password" required>

      <label for="trader-type">Select your trader type:</label>
      <select id="trader-type" name="trader-type" required>
        <!--Js will populate this-->
      </select>

      <label for="phone">Phone Number:</label>
      <input type="tel" id="phone" name="phone">

      <button type="submit" class="submit-btn">Register</button>
    </form>
  </div>

  @include('components.footer') 
  <script src="js/traderregister.js"></script>
</body>
</html>
